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
        getDataSource:(state) => {
            return state.datasource ;
        },
        getQuantidade:(state)=>{
            return state.quantidadeLivros;
        },
        getMessages:(state) => {
            return state.messages;
        },
        getUsersId:(state)=>{
            return state.user;
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

            this.user.meuPerfilController = ref(new MeuPerfilController(api_token), meuperfil);
        },
        atualizarDataSource( quantidade:number, pagina:number)
        {
            this.messages.carregando = true ;
            const dados = {
                quantidade : quantidade ,
                pagina : pagina ,
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
        postLivros(dataSource:object)
        {

            let datasource = dataSource;
            var retorno : number ;
            this.message.carregando = true ;
            const dados = this.user.meuPerfilController.getDadosLivros(datasource) ;
            console.log(dados);
            this.user.meuPerfilController.postLivros(dados).then((response)=>{
                console.log(response);
                if(response.status === 201){
                    this.message('sucesso');
                    this.atualizarDataSource( 6 , 0);
                    retorno = 201 ;
                }else{

                    this.message('erro');
                    retorno = 500 ;
                }
            }).catch( ()=>{
                this.message('erro');
                retorno = 500;
            }).finally( () =>{
                this.message.carregando = false ;
                return retorno ;
            });

        },
        putLivros(datasource:object) : number
        {
            this.message.carregando = true ;


            const dados = this.user.meuPerfilController.getDadosLivros(datasource) ;
            var retorno:number ;
            this.user.meuPerfilController.putLivros(dados).then((response)=>{
                if(response.status === 200){
                    this.message('sucesso');
                    this.atualizarDataSource( 6 , 0);
                    retorno = 200 ;
                }else{
                    if(response.status === 204){
                        this.message('alerta');
                        console.log(response);
                        retorno = 204;
                    }
                    else{
                    console.log(response);
                    this.message('erro');
                    retorno = 500 ;
                }
                }
            }).catch( ()=>{
                this.message('erro');
                return 500;
            }).finally( () =>{
                this.message.carregando = false ;
                return retorno ;
            });
        },
        deleteLivros(id:number): number
        {
            var retorno : number ;
            this.message.carregando = true ;
            const dados = this.user.meuPerfilController.getDeleteLivros(id);
            this.user.meuPerfilController.deleteLivros(dados).then((response)=>{
                if( response.status === 200 )
                {
                    this.atualizarDataSource( 6 , 0);
                    retorno = 200 ;
                }else{
                    console.log(response);
                    this.message('alert');
                    retorno = 204 ;
                }

            }).catch((response)=>{
                console.log(response);
                this.message('error');
                retorno = 500 ;
            }).finally(()=>{
                this.messages.carregando= false;
                return retorno ;
            });
        },
        putMeuPerfil(datasource : object ) : number
        {
            var retorno : number ;
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
                return retorno;
            });
        },
    }

} );
