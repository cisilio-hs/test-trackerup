<template>
    <app-layout title="Peças">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Peças
            </h2>
        </template>

        <div class="py-12">
            <div class="w-full">
                <div class="mx-auto sm:px-6 lg:px-8">



                    <div class="w-full flex flex-row-reverse gap-4">



                        <button
                            @click.prevent="clickNew()"
                            class="bg-transparent hover:bg-green-700 text-green-700 font-semibold hover:text-white py-1 px-5 border border-green-500 hover:border-transparent rounded"
                        >
                            Novo
                        </button>

                        <div class="flex flex-grow gap-2">
                            <button
                                @click.prevent="updateList()"
                                class="bg-transparent hover:bg-blue-700 text-blue-700 font-semibold hover:text-white py-1 px-5 border border-blue-500 hover:border-transparent rounded"
                            >
                                Buscar
                            </button>
                            <div class="w-1/6 text-right">Categoria</div>
                            <input
                                @keyup.enter="updateList()"
                                class="w-full text rounded py-0"
                                type="text"
                                v-model="searchCategoria"
                            />
                        </div>

                    </div>


                    <div class="bg-white shadow-md rounded my-6 overflow-x-auto h-80">
                        <table class="min-w-max w-full table-auto">
                            <thead class="">
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">#</th>
                                    <th class="py-3 px-6 text-left">Código</th>
                                    <th class="py-3 px-6 text-left">Categoria</th>
                                    <th class="py-3 px-6 text-left">Nome</th>
                                    <th class="py-3 px-6 text-center">Criado</th>
                                    <th class="py-3 px-6 text-center">Editado</th>
                                    <th class="py-3 px-6 text-center">Ação</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light overflow-y-auto max-h-40">
                                <tr v-for="peca in pecas" :key="peca.id"
                                    class="border-b border-gray-200 hover:bg-gray-100"
                                >
                                    <td class="py-3 px-6 text-left whitespace-nowrap" v-html="peca.id" />
                                    <td class="py-3 px-6 text-left whitespace-nowrap" v-html="peca.codigo" />
                                    <td class="py-3 px-6 text-left whitespace-nowrap" v-html="peca.categoria" />
                                    <td class="py-3 px-6 text-left whitespace-nowrap" v-html="peca.nome" />
                                    <td class="py-3 px-6 text-center whitespace-nowrap" v-html="formatedDate(peca.created_at)" />
                                    <td class="py-3 px-6 text-center whitespace-nowrap" v-html="formatedDate(peca.updated_at)" />


                                    <td class="py-3 px-6 text-center">
                                        <div class="flex item-center justify-center">

                                            <div @click="viewPeca(peca.id)"
                                                class="hidden cursor-pointer w-4 mr-2 transform hover:text-blue-500 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </div>

                                            <div @click="loadEditData(peca.id)"
                                                class="cursor-pointer w-4 mr-2 transform hover:text-blue-500 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </div>

                                            <div @click="clickDelete(peca.id,peca.codigo)"
                                                class="cursor-pointer w-4 mr-2 transform hover:text-red-600 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </app-layout>





    <div  v-show="modalNew.visible"  @click.self="closeNewModal()"
        class="flex z-40  items-center justify-center fixed left-0 bottom-0 w-full h-full bg-opacity-50 bg-black">

        <div class="bg-white rounded-lg w-1/2">
            <div class="flex flex-col items-start p-4">
            <div class="flex items-center w-full">
                <div class="text-gray-900 font-medium text-lg">{{ modalNew.id }} - {{ modalNew.codigo }}</div>
                <svg  @click="closeNewModal()"
                  class="ml-auto fill-current text-gray-700 w-6 h-6 cursor-pointer   hover:text-blue-500 hover:scale-110" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"/>
                </svg>
            </div>
            <hr>
            <div class="w-full py-4">
                <div class="flex w-full mb-2 gap-2">
                    <div class="w-2/6 text-right">Código</div>
                    <input class="w-4/6 text rounded py-0" type="text" v-model="modalNew.codigo">
                </div>
                <div class="flex w-full mb-2 gap-2">
                    <div class="w-2/6 text-right">Categoria</div>
                    <input class="w-4/6 text rounded py-0" type="text" v-model="modalNew.categoria">
                </div>
                <div class="flex w-full mb-2 gap-2">
                    <div class="w-2/6 text-right">Nome</div>
                    <input class="w-4/6 text rounded py-0" type="text" v-model="modalNew.nome">
                </div>
                <div class="flex w-full mb-2 gap-2">
                    <div class="w-2/6 text-right">Descricao</div>
                    <input class="w-4/6 text rounded py-0" type="text" v-model="modalNew.descricao">
                </div>
            </div>
            <hr>
            <div class="ml-auto gap-2">
                <button
                    @click.prevent="sendCreation()"
                    class="bg-transparent hover:bg-blue-700 text-blue-700 font-semibold hover:text-white py-1 px-5 border border-blue-500 hover:border-transparent rounded">
                    Salvar
                </button>
            </div>
            </div>
        </div>
    </div>

    <div  v-show="modalEdit.visible"  @click.self="closeEditModal()"
        class="flex z-40  items-center justify-center fixed left-0 bottom-0 w-full h-full bg-opacity-50 bg-black">

        <div class="bg-white rounded-lg w-1/2">
            <div class="flex flex-col items-start p-4">
            <div class="flex items-center w-full">
                <div class="text-gray-900 font-medium text-lg">{{ modalEdit.id }} - {{ modalEdit.codigo }}</div>
                <svg  @click="closeEditModal()"
                  class="ml-auto fill-current text-gray-700 w-6 h-6 cursor-pointer   hover:text-blue-500 hover:scale-110" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"/>
                </svg>
            </div>
            <hr>
            <div class="w-full py-4">
                <div class="flex w-full mb-2 gap-2">
                    <div class="w-2/6 text-right">Código</div>
                    <input class="w-4/6 text rounded py-0" type="text" v-model="modalEdit.codigo">
                </div>
                <div class="flex w-full mb-2 gap-2">
                    <div class="w-2/6 text-right">Categoria</div>
                    <input class="w-4/6 text rounded py-0" type="text" v-model="modalEdit.categoria">
                </div>
                <div class="flex w-full mb-2 gap-2">
                    <div class="w-2/6 text-right">Nome</div>
                    <input class="w-4/6 text rounded py-0" type="text" v-model="modalEdit.nome">
                </div>
                <div class="flex w-full mb-2 gap-2">
                    <div class="w-2/6 text-right">Descricao</div>
                    <input class="w-4/6 text rounded py-0" type="text" v-model="modalEdit.descricao">
                </div>
            </div>
            <hr>
            <div class="ml-auto gap-2">
                <button
                    @click.prevent="sendUpdate()"
                    class="bg-transparent hover:bg-blue-700 text-blue-700 font-semibold hover:text-white py-1 px-5 border border-blue-500 hover:border-transparent rounded">
                    Salvar
                </button>
            </div>
            </div>
        </div>
    </div>

    <div  v-show="modalDelete.visible"  @click.self="closeDeleteModal()"
        class="flex z-40  items-center justify-center fixed left-0 bottom-0 w-full h-full bg-opacity-50 bg-red-900">

        <div class="bg-white rounded-lg w-1/2">
            <div class="flex flex-col items-start p-4">
            <div class="flex items-center w-full">
                <div class="text-gray-900 font-medium text-lg">{{ modalDelete.id }} - {{ modalDelete.codigo }}</div>
                <svg  @click="closeDeleteModal()"
                  class="ml-auto fill-current text-gray-700 w-6 h-6 cursor-pointer   hover:text-blue-500 hover:scale-110" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"/>
                </svg>
            </div>
            <hr>
            <div class="w-full py-4">
                A Peça será excluida. Deseja continnuar?
            </div>
            <hr>
            <div class="ml-auto gap-2">
                <button
                    @click.prevent="confirmDelete()"
                    class="bg-transparent hover:bg-red-700 text-red-700 font-semibold hover:text-white py-1 px-5 border border-red-500 hover:border-transparent rounded">
                    Excluir
                </button>
            </div>
            </div>
        </div>
    </div>

</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue'
    import Welcome from '@/Jetstream/Welcome.vue'
    import axios from "axios";
    import moment from 'moment';

    export default {
        components: {
            AppLayout,
            Welcome,
        },
        data() {
            return {
                pecas: [],
                searchCategoria: '',
                modalEdit:{
                    visible: false,
                },
                modalDelete:{
                    visible: false,
                    id: '',
                    codigo: '',
                },
                modalNew:{
                    visible: false,
                }
            }
        },
        computed:{
            // computedPecas(){
            //     return pecas;
            // },
        },
        methods:{
            updateList(){
                axios.get( route('pecas.index', { categoria: this.searchCategoria } ) )
                .then(response => {
                    this.pecas = response.data.data
                })
            },
            formatedDate(date){
                return moment(date).format("DD/MM/YYYY, hh:mm:ss");
            },
            loadEditData(peca_id){

                axios.get( route('pecas.show',peca_id) )
                .then(response => {
                    this.modalEdit.id = response.data.id;
                    this.modalEdit.codigo = response.data.codigo;
                    this.modalEdit.codigo = response.data.codigo;
                    this.modalEdit.categoria = response.data.categoria;
                    this.modalEdit.nome = response.data.nome;
                    this.modalEdit.created_at = response.data.created_at;
                    this.modalEdit.updated_at = response.data.updated_at;
                    this.modalEdit.visible = true;
                });

            },
            sendUpdate(){
                axios.post(
                    route('pecas.update',this.modalEdit.id) ,
                    this.modalEdit

                ).then( (response) => {
                    // console.log(response);
                    this.closeEditModal();
                    this.updateList();
                })
                .catch( (error) => {
                    console.log(error.message);
                    console.log(error.response.data);
                });
            },
            closeEditModal(){
                this.modalEdit.visible = false;
            },
            clickDelete(peca_id, peca_codigo){
                this.modalDelete.id = peca_id;
                this.modalDelete.codigo = peca_codigo;
                this.modalDelete.visible = true;
            },
            confirmDelete(){
                axios.delete( route('pecas.destroy',this.modalDelete.id) )
                .then( (response) => {
                    // console.log(response);
                    this.closeDeleteModal();
                    this.updateList();
                });
            },
            closeDeleteModal(){
                this.modalDelete.visible = false;
            },
            clickNew(){
                this.modalNew = { visible: true };
            },
            sendCreation(){
                axios.post(
                    route('pecas.store') ,
                    this.modalNew

                ).then( (response) => {
                    // console.log(response);
                    this.closeNewModal();
                    this.updateList();
                })
                .catch( (error) => {
                    console.log(error.message);
                    console.log(error.response.data);
                });
            },
            closeNewModal(){
                this.modalNew.visible = false;
            },
            viewPeca(peca_id){
                console.log('view ' + peca_id);
            },
        },
        mounted(){
            this.updateList();

        }

    }
</script>
