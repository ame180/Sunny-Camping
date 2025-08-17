const allowedKeys = [
  'page',
  'unregistered',
  'cash_register',
  'terminal',
  'voucher',
  'invoice',
  'departure_date',
  'status',
  'token_number',
  'query'
];

export function normalizeQueryParams(params) {
  const out = {};
  allowedKeys.forEach(k => {
    const v = params && params[k];
    if (v !== undefined && v !== null && v !== '') out[k] = v;
  });

  return out;
}

export function queryParamsToString(params) {
  const f = normalizeQueryParams(params);
  const p = new URLSearchParams();
  Object.keys(f).forEach(k => {
    const v = f[k];
    if (v === true) p.append(k, 'true');
    else p.append(k, String(v));
  });
  const qs = p.toString();

  return qs ? `?${qs}` : '';
}

export function appendQueryParamsToPath(path, params) {
  return `${path}${queryParamsToString(params)}`;
}

export function parseQueryParamsFromSearch(search) {
  const params = new URLSearchParams(search || '');
  const out = {};
  allowedKeys.forEach(k => {
    const v = params.get(k);
    if (v !== null && v !== '') out[k] = v;
  });

  return out;
}
