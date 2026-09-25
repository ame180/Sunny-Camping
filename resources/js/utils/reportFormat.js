const currencyFormat = new Intl.NumberFormat('pl-PL', { style: 'currency', currency: 'PLN' });
const axisCurrencyFormat = new Intl.NumberFormat('pl-PL', { style: 'currency', currency: 'PLN', maximumFractionDigits: 0 });
const countFormat = new Intl.NumberFormat('pl-PL');

export const SERIES_COLORS = ['#2a78d6', '#eb6834', '#1baf7a', '#eda100', '#e87ba4', '#008300', '#4a3aa7', '#e34948'];

export function formatReportValue(value, unit) {
    return unit === 'currency' ? currencyFormat.format(value) : countFormat.format(value);
}

export function formatReportAxisValue(value, unit) {
    return unit === 'currency' ? axisCurrencyFormat.format(value) : countFormat.format(value);
}
