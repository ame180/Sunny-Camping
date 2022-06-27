<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientItem;
use App\Repositories\ClientItemRepository;
use App\Repositories\ClientRepository;
use App\Validators\ClientPersistenceValidator;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    private ClientRepository $clientRepository;
    private ClientPersistenceValidator $clientPersistenceValidator;
    private ClientItemRepository $clientItemRepository;

    public function __construct(ClientRepository $clientsRepository, ClientPersistenceValidator $clientPersistenceValidator, ClientItemRepository $clientItemRepository)
    {
        $this->clientRepository = $clientsRepository;
        $this->clientPersistenceValidator = $clientPersistenceValidator;
        $this->clientItemRepository = $clientItemRepository;
    }

    public function get($id)
    {
        return $this->clientRepository->find($id)->toJson();
    }

    public function getMultiple(Request $request)
    {
        return $this->clientRepository->paginate($request->get('per_page'), $request->get('sort'));
    }

    public function add(Request $request)
    {
        $client = new Client();

        $client->fill($request->all());

        if ($this->clientPersistenceValidator->isValid($client)) {
            $this->clientRepository->save($client);
            foreach ($request->get('client_items') as $clientItemRaw) {
                $clientItem = new ClientItem();
                $clientItem->fill($clientItemRaw);
                $clientItem->id = null;
                $client->clientItems()->save($clientItem);
            }

            return true;
        }

        return response('', 400);
    }

    public function update(Request $request, int $id)
    {
        /** @var Client $client */
        $client = $this->clientRepository->find($id);

        $client->fill($request->all());

        if ($this->clientPersistenceValidator->isValid($client)) {
            $this->clientRepository->save($client);
            $client->clientItems()->delete();

            foreach ($request->get('client_items') as $clientItemRaw) {
                $clientItem = new ClientItem();
                $clientItem->fill($clientItemRaw);
                $client->clientItems()->save($clientItem);
            }

            return true;
        }

        return response('', 400);
    }

    public function delete($id)
    {
        $this->clientRepository->delete($this->clientRepository->find($id));
    }

    public function settle(Request $request, int $id)
    {
        $settlement = $request->get('settlement') ?? 0;
        $climateSettlement = $request->get('climate_settlement') ?? 0;

        if ($settlement <= 0 && $climateSettlement <= 0) {
            return response('', 400);
        }

        $client = $this->clientRepository->find($id);
        if (!isset($client)) {
            return response('', 400);
        }

        $client->paid += $settlement;
        $client->climate_paid += $climateSettlement;

        if ($client->paid + $client->climate_paid >= $client->price + $client->climate_price) {
            $client->status = 'settled';
        } else {
            $client->status = 'unsettled';
        }
        $this->clientRepository->save($client);

        return true;
    }

    public function exportRegistered(Request $request)
    {
        $filename = 'camping.csv';
        $clients = $this->clientRepository->findAllRegisteredClients();

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = ['Imię i nazwisko', 'Data przyjazdu', 'Data wyjazdu', 'Ilość osób'];

        $callback = function () use ($clients, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            /** @var Client $client */
            foreach ($clients as $client) {
                $row['name'] = $client->name;
                $row['arrival_date'] = $client->arrival_date;
                $row['departure_date'] = $client->departure_date;
                $row['people_count'] = 0;

                foreach ($client->clientItems as $clientItem) {
                    if ('Osoby' === $clientItem->serviceCategory?->name) {
                        $row['people_count'] += $clientItem->count;
                    }
                }

                fputcsv($file, [
                    $row['name'],
                    $row['arrival_date'],
                    $row['departure_date'],
                    $row['people_count'], ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
