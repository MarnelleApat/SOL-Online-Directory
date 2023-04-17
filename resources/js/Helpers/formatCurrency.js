// format currency
const formatPrice = (value, _currency='USD') => {
    var formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: _currency,
        minimumFractionDigits: 2
    });
    return formatter.format(value);
}

export default formatPrice
