import { ref , computed } from "vue";
import { defineStore } from 'pinia';
import { MeuPerfilController } from "@/MeuPerfil/meuperfilController";

export const meuperfilStore = defineStore('meuperfil',{
    state: () => {
        return {
                user :{
                api_token : 'Bearer ' ,
                users_id : 0 ,
                meuperfil_id: 0 ,
                meuPerfilController : null ,
            },
            datasource:{

            },
            quantidadeLivros : 0 ,
            messages:{
                erro : false ,
                alerta : false ,
                sucesso : false ,
                carregando : false ,
            }
        }
    },
    getters: {
        getApiToken: (state) => {
          return state.user.api_token;
        },
        getDataSource:(state) => {
            return state.datasource ;
        },
        getQuantidade:(state)=>{
            return state.quantidadeLivros;
        },
        getMessages:(state) => {
            return state.messages;
        }

    },
    actions: {
        message(tipo:string){
            switch(tipo){
                case 'erro':this.messages.erro=true;setTimeout(()=>{this.messages.erro=false;},2000);break;
                case 'alerta':this.messages.alerta=true;setTimeout(()=>{this.messages.alerta=false;},2000);break;
                case 'sucesso':this.messages.sucesso=true;setTimeout(()=>{this.messages.sucesso=false;},2000);break;
                default :this.messages.erro=true;setTimeout(()=>{this.messages.erro=false;},2000);break;
            }
        },
        setUser(meuperfil:object , api_token: string , quantidadeLivros : number, datasource?:object )
        {
            this.user.api_token = api_token ;
            this.user.users_id = meuperfil.users_id ;
            this.user.meuperfil_id = meuperfil.meuperfil_id;
            this.quantidadeLivros = quantidadeLivros ;
            this.datasource = datasource ;
            this.user.meuPerfilController = ref(new MeuPerfilController(api_token));
        },
        atualizarDataSource()
        {
            this.messages.carregando = true ;
            const dados = {
                quantidade : 6 ,
                pagina : 0 ,
                meuperfil_id : this.user.meuperfil_id,
            };
            this.user.meuPerfilController.getDadosLivrosMeuPerfil(dados).then( response =>{
                if(response.status === 200 ){
                    this.datasource = response.data;
                }else{
                    if(response.status >= 500)
                    {
                        console.log(response);
                        this.message('erro');
                    }
                }
            }
            ).catch( ()=>{
                this.message('erro');
            })
            .finally(()=>{
                this.messages.carregando = false ;
            });
        },
        postLivros(datasource:object)
        {
            this.message.carregando = true ;
            const dados = this.user.meuPerfilController.getDadosLivros(datasource) ;
            this.user.meuPerfilController.postLivros(dados).then((response)=>{
                if(response.status === 201){
                    this.message('sucesso');
                    this.atualizarDataSource();
                }else{
                    console.log(response);
                    this.message('erro');
                }
            }).catch( ()=>{
                this.message('erro');
            }).response( () =>{
                this.message.carregando = false ;
            });

        },
        putLivros(datasource:object)
        {
            this.message.carregando = true ;
            const dados = this.user.meuPerfilController.getDadosLivros(datasource) ;
            this.user.meuPerfilController.putLivros(dados).then((response)=>{
                if(response.status === 200){
                    this.message('sucesso');
                    this.atualizarDataSource();
                }else{
                    if(response.status === 204){
                        this.message('alerta');
                        console.log(response);
                    }
                    else{
                    console.log(response);
                    this.message('erro');
                }
                }
            }).catch( ()=>{
                this.message('erro');
            }).response( () =>{
                this.message.carregando = false ;
            });
        },
        deleteLivros(id:number)
        {
            this.message.carregando = true ;
            const dados = this.user.meuPerfilController.getDeleteLivros(id);
            this.user.meuPerfilController.deleteLivros(dados).then((response)=>{
                if( response.status === 200 )
                {
                    this.atualizarDataSource();
                }else{
                    console.log(response);
                    this.message('alert');
                }

            }).catch((response)=>{
                console.log(response);
                this.message('error');
            }).finally(()=>{
                this.messages.carregando= false;
            });
        },
        putMeuPerfil(datasource : object ){
            this.message.carregando = true ;
            const dados = this.user.meuPerfilController.getPutMeuPerfil(datasource);
            this.user.meuPerfilController.putMeuPerfil(dados).then((response) =>{
                if(response.status === 200 )
                {
                    this.message('sucesso');
                }else{
                    if(response.status===204){
                        this.message('alerta');
                        console.log(response);
                    }else{
                        this.message('erro');
                        console.log(response);
                    }
                }

            }).catch( (response)=>{
                this.message('error');
            }).finally((response)=>{
                this.messages.carregando=false;
            });
        },



    }
} );
