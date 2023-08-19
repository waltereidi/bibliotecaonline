import { expect, test } from 'vitest'
import { MeuPerfilController } from "@/MeuPerfil/Controllers/meuperfilController";
import { axios } from 'axios';
import { ApiRequest } from '@/Utils/ApiRequest';
import { MeuPerfilDados } from '@/MeuPerfil/Entidades/meuperfilDados';

const a = 1 ;
const b = 2 ;

const meuperfilController = new MeuPerfilController;
const apiRequest = new ApiRequest;



test('somar', () => {
    const expected = meuperfilController.somar(a, b);

  expect(expected ).toBe(3)
})

test('getDadosMeuPerfil', () => {
    const user :Users = apiRequest.getTestToken('testCase@email.com', 'testCase');
    const retorno: MeuPerfilDados = meuperfilController.getDadosMeuPerfil(user.api_token);
    expect(retorno.id).not.toBeNull();

})
