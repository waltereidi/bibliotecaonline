import { Users } from '@/Utils/Entidades/users';
import  axios  from 'axios';

export class ApiRequest {

    getDefaultHeaders(api_token: string) : object {
        return {
            'Authorization': `Bearer ${api_token}` ,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Accept-Encoding': 'gzip, deflate, br',
            'Connection': 'keep-alive'
        }
    }
    async getTestToken(email: string, password: string) :Users {
        const body: object = {
            'email': email,
            'password': password ,
        };
        return await axios.post('/api/users/getDadosUsers', body);



    }
}
