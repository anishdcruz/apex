import Vue from 'vue'

Vue.filter('formatMoney', function(value, currency, code = false) {
    var amount = parseFloat(value)
        .toFixed(currency.decimal_place)

    if(code) {
        return amount + ' ' + currency.code
    }

    return amount
})


Vue.filter('formatDate', function(value) {
    const months = {
        '01':'Jan', '02':'Feb', '03':'Mar', '04':'Apr', '05':'May', '06':'Jun',
        '07':'Jul', '08':'Aug', '09':'Sep', '10':'Oct', '11':'Nov', '12':'Dec'
    }
    const parts = String(value).split('-')
    return `${parts[2]}-${months[parts[1]]}-${parts[0]}`
})