import { MeuPerfilController } from "@/MeuPerfil/Controllers/meuperfilController";

const a = 1 ;
const b = 2 ;


describe('somar', () => {
    const meuperfilController = new MeuPerfilController;
    it.only('Somar retorna soma de dois numeros.' , ()=>{
        const expected = a + b;
        const actual = meuperfilController.somar(a , b);

        expect(actual).toBe(expected);

    })

})
