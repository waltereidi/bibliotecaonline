import { Users } from '@/Utils/Entidades/users';
import  axios  from 'axios';

export class ApiRequest {

    getDefaultHeaders(api_token: string) : object {
        return {
        'Authorization': `Bearer ${api_token}` ,
        'Content-Type': 'application/json' };
    }
     getTestToken(email: string, password: string) :Users {
        const body: object = {
            'email': email,
            'password': password ,
        };

        const retorno: Users =  axios.post<Users>('/api/users/getDadosUsers', body);
        return retorno;
    }
}
