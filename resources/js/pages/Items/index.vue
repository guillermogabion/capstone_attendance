<template>
    <div>
        <v-col>
           <v-card min-height="1%" max-height="1%">
            <div>
            <v-row
            class="ma-3"
            >
                <v-card-title>
                Items
                </v-card-title>
                <v-spacer></v-spacer>
                <v-row
                justify="center"
               
                >
                    <v-col
                    class="ma-2"
                    >
                        <v-text-field
                        auto-select-first
                        :items="items"
                        filled 
                        clearable
                        ref="sfield"
                        rounded 
                        v-model="form.search"
                        dense 
                        single-line 
                        append-icon="mdi-magnify" 
                        class="mx-4 mt-5"
                    ></v-text-field>
                    </v-col>
                    <v-col
                    class="ma-2"
                    >
                        <v-select
                        class="pa-2 selects ins"
                        height="20%"
                        :items="items"
                       solo
                        label="Category"
                        dense
                        
                        ></v-select>
                    </v-col>
                </v-row>
               
            </v-row>
            </div>
           </v-card>
        </v-col>
        <v-col>
           <v-row class="ma-1">
            <v-col v-for="item in items" :key="item.id"
                cols="16" :lg="2" :sm="8" :md="2" :xs="10" 
            >
            <v-card
            class="mx-auto"
            max-width="280"
            max-height="310"
            min-height="340"
            >
            {{item.name}}
            {{item.brand}}
            {{item.description}}
            {{item.stock}}
            {{item.sold}}
            </v-card>

            </v-col>

           </v-row>
        </v-col>
    </div>
</template>
<script>
import axios from '../../plugins/axios';

    export default {
        data() {
            return {
                items: [],
                form : {
                    search: '',
                },
                loading : false
            }
        },
        mounted (){
            this.searchItem()
        },
        methods: {
            searchItem(key) {
                this.loading = true
                if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
                }
                this.timer = setTimeout(() => {
                axios.post('get').then((response) => {
                    this.items = response.data 
                    this.loading = false
                }).catch((errors) => {
                    console.log(errors)
                });
                },800);
            },
        },
        watch: {
            "form.search": {
                handler(val) {
                this.searchItem(val)
                },
                deep: true,
            },
        }
    }
   
</script>
<style>
.selects .v-input__slot {
  padding: 11px !important;
}

</style>