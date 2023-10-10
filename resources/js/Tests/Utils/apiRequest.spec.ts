import { expect, test ,describe } from 'vitest';
import { ApiRequest } from '@/Utils/apiRequest';
import { Users } from '@/Utils/Entidades/users';
import axios  from 'axios';
const apiRequest = new ApiRequest;

describe('apirequest testes ', () => {

    test('getDefaultHeaders', async () => {
    const api_token: string = 'Token';
    const retorno: object = await apiRequest.getDefaultHeaders(api_token);
    expect(retorno['Authorization']).toBe('Bearer Token');
    expect(retorno['Content-Type']).toBe('application/json');

});

});






