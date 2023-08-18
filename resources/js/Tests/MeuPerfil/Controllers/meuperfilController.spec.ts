import { expect, test } from 'vitest'
import { MeuPerfilController } from "@/MeuPerfil/Controllers/meuperfilController";
import { axios } from 'axios';
const a = 1 ;
const b = 2 ;

const meuperfilController = new MeuPerfilController;


test('somar', () => {
    const expected = meuperfilController.somar(a, b);

  expect(expected ).toBe(3)
})

test('getDadosMeuPerfil', () => {
    const retorno = meuperfilController.getDadosMeuPerfil('')

})
