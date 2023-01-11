import axios from 'axios'

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

export function axiosDelete(url) {
    var token = document.getElementById('csrf-token')
    return new Promise((resolve, reject) => {
        axios.delete(url, {
            headers: {
                'X-CSRFToken': token.content
            }
        })
            .then((response) => {
                resolve(response)
            })
            .catch((error) => {
                reject(error)
            })
    })
}

export function postBookingConfirmed (url, payload) {
    return new Promise((resolve, reject) => {
        axios({
            method: 'POST',
            url: url,
            data: {confirmed: payload},
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