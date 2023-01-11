import axios from "axios/index";

export function postAccommodationOrder (url, payload) {
    let request = {
        tour_id:            typeof payload.tour_id !== 'undefined' ?  payload.tour_id : null,
        date_in:            typeof payload.date_in !== 'undefined' ?  payload.date_in : null,
        cost:               typeof payload.cost !== 'undefined' ?  payload.cost : null,
        food:               typeof payload.food !== 'undefined' ?  payload.food : null,
        add_transfer:       typeof payload.add_transfer !== 'undefined' ?  payload.add_transfer : null,
        accommodations:     typeof payload.accommodations !== 'undefined' ?  payload.accommodations : null,
        currency_code:      typeof payload.currency_code !== 'undefined' ?  payload.currency_code : null,
        food_cost:          typeof payload.food_cost !== 'undefined' ?  payload.food_cost : null,
        flight_cost:        typeof payload.flight_cost !== 'undefined' ?  payload.flight_cost : null,
        transfer_cost:      typeof payload.transfer_cost !== 'undefined' ?  payload.transfer_cost : null,
        notes:              payload.notes
    }
    return new Promise((resolve, reject) => {
        axios.post(url, request)
            .then((response) => {
                resolve(response)
            })
            .catch((error) => {
                reject(error)
            })
    })
}

// проверка объекта на пустоту
export function isEmpty(obj) {
    for(var key in obj) {
        if(obj.hasOwnProperty(key))
            return false;
    }
    return true;
}

export function postJSON (url, payload) {
    return new Promise((resolve, reject) => {
        axios({
            method: 'POST',
            url: url,
            data: payload,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            json: true
        })
            .then((response) => {
                resolve(response)
            })
            .catch((error) => {
                reject(error)
            })
    })
}
