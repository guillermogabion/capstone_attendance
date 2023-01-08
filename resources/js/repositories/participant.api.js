import Axios from "../plugins/axios"

export const ParticipantPagination = (url, payload) => Axios.get(`/${url}`, payload)
