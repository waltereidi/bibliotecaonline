import { MeuPerfilDados } from "@/MeuPerfil/Entidades/meuperfilDados";
import axios from "axios";
import { ApiRequest } from "../../Utils/ApiRequest";

export class MeuPerfilController{

    somar( a:number , b:number ) : number {
        return a+b ;
    }
    getDadosMeuPerfil(api_token: string) :MeuPerfilDados {
        const apiRequest: ApiRequest = new ApiRequest();

        const body: object = apiRequest.getDefaultHeaders(api_token);

        const retorno: MeuPerfilDados = axios.post<MeuPerfilDados>('/api/getDadosMeuPerfil',
            body
        );
        return retorno;

    }
}
