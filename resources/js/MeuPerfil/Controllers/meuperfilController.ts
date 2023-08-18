import { MeuPerfilDados } from "@/MeuPerfil/Entidades/meuperfilDados";
import  axios  from "axios";
export class MeuPerfilController{

    somar( a:number , b:number ) : number {
        return a+b ;
    }
    getDadosMeuPerfil(api_token : string ) {
        const body:object = { "Authorization" : api_token  };
        const retorno:MeuPerfilDados = axios.post<MeuPerfilDados>('/api/getDadosMeuPerfil',

        )

    }
}
