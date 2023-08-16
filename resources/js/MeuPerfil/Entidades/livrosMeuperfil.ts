import { LivrosSituacaoEnum } from "@/livrosituracaoenum";

interface LivrosMeuPerfil {
    users_id : number ,
    titulo : string ,
    isbn? : string ,
    descricao? : string ,
    visibilidade : LivrosSituacaoEnum ,
    editoras_id : number ,
    editoras_nome : string ,
    autores_id : number ,
    autores_nome : string ,
    idioma? : string ,
    genero? : string ,
    capalivro? : string ,
}
