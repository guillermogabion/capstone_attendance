<template>
    <v-app>
        <div>
        <v-sheet
        style="max-height: 101.2vh;"
        fluid
        >
        <div class="text-center login">
                        <v-card
                        width="500"
                        class="mx-auto"
                        elevation="3"
                        color="white"
                        >
                        <v-card>
                            <div
                             style="padding-top: 4%"
                            >
                            <v-img 
                            contain
                            :src="logocard"
                            max-height="30%"
                            width="50%"
                            class="mx-auto"
                            />
                        </div>
    
                        <v-col>

                           <h3 class="bold"> Event Name</h3>                            
                           <v-text-field
                                v-model="payload.event_name"
                                filled
                                rounded
                                dense
                            ></v-text-field>
                           <h3 class="bold"> Please Scan Your QR Code</h3>                            
                           <v-text-field
                                v-model="payload.code"
                                filled
                                rounded
                                dense
                                label="Code"
                            ></v-text-field>
                    
                            <!-- <v-text-field
                                v-model="password"
                                filled
                                rounded
                                dense
                                :type="isPasswordVisible ? 'text' : 'password'"
                                label="Password"
                                placeholder="············"
                                :append-icon="isPasswordVisible ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
                                @click:append="isPasswordVisible = !isPasswordVisible"
                            
                            ></v-text-field> -->
                            
                            <v-card-actions>
                            <!-- <v-spacer></v-spacer>
                                <v-btn
                                    rounded
                                    color="success"
                                    class= "mb-2 px-7"
                                    @click="Login()"
                                >
                                    Login
                                </v-btn>
                                <v-btn
                                    rounded
                                    color="primary"
                                    class= "mb-2 px-3"
                                >
                                    Register
                                </v-btn> -->
                            <v-spacer></v-spacer>
                            </v-card-actions>
                        </v-col>
                        </v-card>
                        </v-card>
                        <!-- <v-snackbar
                            v-model="snackbar"
                            :timeout="timeout"
                            >
                            {{ text }}

                            <template v-slot:action="{ attrs }">
                                <v-btn
                                color="blue"
                                text
                                v-bind="attrs"
                                @click="snackbar = false"
                                >
                                Close
                                </v-btn>
                            </template>
                        </v-snackbar> -->
                        <v-dialog
                        v-model = "dialog"
                        width="20%"
                        >
                            <v-card

                            >
                                <h2> Student is not Active </h2>

                                <v-btn
                                    @click=" this.dialog = false "
                                >Close</v-btn>
                            </v-card>
                        </v-dialog>
                    </div>
         
        </v-sheet>
    </div>
         
    
        <!-- <v-card
          class="mx-auto"
          max-width="344"
          padding-top="20px"
          outlined
        >
          
      
          <v-card-actions>
          
          </v-card-actions>
        </v-card> -->
    </v-app>
    </template>
    <script>
    import logo from '../../assets/logg.png'
    import logocard from '../../assets/logg.png'
    import axios from '../../plugins/axios'
    export default {
       data() {
        return {
          
            logo, 
            logocard,
            payload : {
                code: '',
                event_name: ''
            },
            loading : false,
            snackbar: false,
            text: 'New Data Added',
            timeout: 2000,
            dialog : false
        }
       },
       methods : {
            saveScan(){
                this.loadding = true
                if (this.timer) {
                    clearTimeout(this.timer);
                    this.timer = null
                }
                this.timer = setTimeout(() => {
                    axios.post('record', this.payload).then((response) => {
                        

                        console.log(response, "I am console")
                     
                    }).catch((errors) => {
                     
                        console.error(errors);
                    });
                }, 800)
               
            }
       },   
       watch : {
        "payload.code": {
        handler() {
          this.saveScan()
        },
        deep: true,
      },
       }
    }
    </script>
    <style>
    /* .login-page {
    padding-top : 10em;
    background-color: green;
    } */
    body {
      overflow: hidden; /* Hide scrollbars */
    }
    
    .login {
        padding-top: 10%;
    }
    
    
    
    .border {
        background-color: white;
        border-top-left-radius: 100% 55%;
        border-bottom-left-radius: 100% 55%;
        height: 100%;
        border-style: solid;
        border-width: 5px;
        box-shadow: 2px 2px 4px #000000;
        padding-left: 2em;
        padding-right: 2em;
    }
    
    </style>