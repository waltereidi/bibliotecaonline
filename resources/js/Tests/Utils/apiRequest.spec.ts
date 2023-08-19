import { expect, test } from 'vitest';
import { ApiRequest } from '@/Utils/ApiRequest';
import { Users } from '@/Utils/Entidades/users';

const apiRequest = new ApiRequest();


test('getDefaultHeaders', () => {
    const api_token: string = 'Token';
    const retorno: object = apiRequest.getDefaultHeaders(api_token);
    expect(retorno['Authorization']).toBe('Bearer Token');
    expect(retorno['Content-Type']).toBe('application/json');

});

test('getDadosUsers', () => {
    const retorno: Users = apiRequest.getTestToken('testCase@email.com' , 'testCase');
    expect(retorno.id).not.toBeNull();


    expect(retorno.api_token).not.toBeNull();
    expect(retorno.validade_token).not.toBeNull();

});


