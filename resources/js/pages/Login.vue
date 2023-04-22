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
                        <v-text-field
                            v-model="email"
                            filled
                            rounded
                            dense
                            label="Username"
                        ></v-text-field>
                
                        <v-text-field
                            v-model="password"
                            filled
                            rounded
                            dense
                            :type="isPasswordVisible ? 'text' : 'password'"
                            label="Password"
                            placeholder="············"
                            :append-icon="isPasswordVisible ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
                            @click:append="isPasswordVisible = !isPasswordVisible"
                        
                        ></v-text-field>
                        
                        <v-card-actions>
                        <v-spacer></v-spacer>
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
                                @click="dialog = true"
                            >
                                Register
                            </v-btn>
                        <v-spacer></v-spacer>
                        </v-card-actions>
                    </v-col>
                    </v-card>

                    <v-dialog
                    v-model="dialog"
                    max-width="400px"
                    >
                        <v-card>
                            <v-card-title>
                                Fill all fields
                            </v-card-title>
                            <div class="px-2">
                                <v-form
                                 ref="form"
                                 v-model="valid"
                                 lazy-validation
                                >
                                    <v-text-field
                                        label="First Name"
                                        outlined
                                        v-model="payload.first_name"
                                        :rules="idRules"
                                    ></v-text-field>
                                    <v-text-field
                                        label="Last name"
                                        outlined
                                        v-model="payload.last_name"
                                        :rules="idRules"
                                    ></v-text-field>
                                    <v-text-field
                                        label="Username"
                                        outlined
                                        v-model="payload.username"
                                        :rules="idRules"
                                    ></v-text-field>
                                    <v-text-field
                                        label="Password"
                                        outlined
                                        v-model="payload.password"
                                        :rules="idRules"
                                    ></v-text-field>
                                      <div class="text-center">
                                            <v-btn
                                                :disabled="!valid"
                                                rounded
                                                color="primary"
                                                dark
                                                class="mb-2"
                                                @click="submit()"
                                            >
                                               Submit
                                            </v-btn>
                                      </div>
                                </v-form>
                            </div>
                        </v-card>
                    </v-dialog>
                    </v-card>
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
import logo from '../assets/logg.png'
import logocard from '../assets/logg.png'
import { mdiEyeOutline, mdiEyeOffOutline } from '@mdi/js'
import { login } from "../repositories/user.api";
import axios from '../plugins/axios'
export default {
   data() {
    return {
        valid : true,
        isPasswordVisible: false,
        icons: {
            mdiEyeOutline,
            mdiEyeOffOutline,
        },
        logo, 
        logocard,
        email: '',
        password: '',
        dialog: false,
         idRules: [
                v => !!v || 'This field is required',
            ],
        payload : {
            first_name : '',
            last_name : '',
            username : '',
            password : ''
        }
    }
   },
   methods : {
        Login() {
          const login_data = {
              email: this.email,
              password: this.password
          }
          login(login_data).then(({data}) => {
            //   this.$store.commit('login', data)
              localStorage.setItem('token', data.access_token)
              console.log(data.user.user_type, "IAM")
              this.routeEnter();

             
                // Call the appropriate function based on user type
                // if (data.user.user_type == 1) {
                //     this.routeEnter();
                // } 
                // if (data.user.user_type == 0) {
                //     this.routeAttend();
                // } 
          }).catch((errors)=> {
              console.log(errors)
              window.alert("Invalid Credentials")
            //   this.snackbar = true
              
          })
        },
        routeEnter(){
            this.$router.push('/attendance');
        },
        routeAttend(){
            this.$router.push('/attendance');
        },
        async submit () {
            const isValid = await this.$refs.form.validate();
            if (isValid){
                axios.post('add-staff', this.payload).then(res => {
                    console.log(res)
                    window.alert("New Staff added. Contact the administrator for approval")
                    this.payload = ''
                    this.dialog = false
                })
            }
        }
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