import axios from 'axios'

export function getByIndex(route, resource, success, error) {
    axios.get(`/api/${resource}`, {
        params: params(route)
    })
        .then(function(response) {
            success(response.data)
        })
        .catch(function(error) {
            error(error)
        })
}

export function getById(route, path, success, error) {
    axios.get(`/api/${path}`)
        .then(function(response) {
            success(response.data)
        })
        .catch(function(error) {
            error(error)
        })
}

function params(route) {
    const query = {
        page: route.query.page || 1,
        per_page: route.query.per_page || 13,
        column: route.query.column || 'id',
        direction: route.query.direction || 'desc',
        search_column: route.query.search_column || 'id',
        search_operator: route.query.search_operator || 'equal_to',
        search_query_1: route.query.search_query_1 || '',
        search_query_2: route.query.search_query_2 || ''
    }
    return query
}