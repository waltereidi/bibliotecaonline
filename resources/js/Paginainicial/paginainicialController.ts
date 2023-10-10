import { IndicesPaginainicial } from "@/Entidades/indicesPaginainicial";
import { PostIndicesPaginainicial } from "@/Entidades/postIndicesPaginainicial";
import { ApiRequest } from "@/Utils/ApiRequest";
import axios from "axios";
export class PaginainicialController{
    public token_aplicativo: string;
    private apiRequest: ApiRequest;
    private headers: object;
    constructor(token_aplicativo: string ) {
        this.token_aplicativo = token_aplicativo;
        this.apiRequest = new ApiRequest;
        this.headers = this.apiRequest.getDefaultHeaders(this.token_aplicativo);
    }

    getDadosBuscaIndice(quantidade:number , iniciopagina:number , busca:Array<object>) : PostIndicesPaginainicial
    {
        let buscaIndices :IndicesPaginainicial= busca;

        const PostIndicesPaginainicial :PostIndicesPaginainicial = {
            busca : buscaIndices,
            quantidade : quantidade,
            iniciopagina : iniciopagina ,
        };
        return PostIndicesPaginainicial;
    }

    getDadosBuscaIndiceRequest(buscaIndice: PostIndicesPaginainicial):object
    {

        return {
            busca : buscaIndice.busca ,
            quantidade : buscaIndice.quantidade ,
            iniciopagina : buscaIndice.iniciopagina ,
            ...this.headers
        }
    }

    getDadosBuscaRequest(busca:string):object
    {

        return {
            busca : busca ,
            ...this.headers
        }
    }
    async getIndices()
    {
        return  await axios.get('/api/paginainicial/getIndices');
    }
    async postBuscaIndice(request:object): Promise<object>
    {
        return await axios.post<object>('/api/paginainicial/postBuscaIndice' , request );
    }
    async postBusca(request:object): Promise<object>
    {
        return await axios.post<object>('/api/paginainicial/postBusca', request);
    }
}
