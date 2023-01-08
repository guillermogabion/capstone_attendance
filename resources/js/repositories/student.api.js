import Axios from "../plugins/axios2";

export const SaveStudent = (payload) => Axios.post('new-record', payload);