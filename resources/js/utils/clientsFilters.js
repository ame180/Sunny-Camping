const allowedKeys = [
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

export function normalizeFilters(filters) {
  const out = {};
  allowedKeys.forEach(k => {
    const v = filters && filters[k];
    if (v !== undefined && v !== null && v !== '') out[k] = v;
  });

  return out;
}

export function filtersToQueryString(filters) {
  const f = normalizeFilters(filters);
  const params = new URLSearchParams();
  Object.keys(f).forEach(k => {
    const v = f[k];
    if (v === true) params.append(k, 'true');
    else params.append(k, String(v));
  });
  const qs = params.toString();

  return qs ? `?${qs}` : '';
}

export function appendFiltersToPath(path, filters) {
  return `${path}${filtersToQueryString(filters)}`;
}

export function parseFiltersFromSearch(search) {
  const params = new URLSearchParams(search || '');
  const out = {};
  allowedKeys.forEach(k => {
    const v = params.get(k);
    if (v !== null && v !== '') out[k] = v;
  });

  return out;
}
