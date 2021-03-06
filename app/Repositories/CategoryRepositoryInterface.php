<?php

interface CategoryRepositoryInterface {
    public function allWithItems(int $serviceId): array;
}
