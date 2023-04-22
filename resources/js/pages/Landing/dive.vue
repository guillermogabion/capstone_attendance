<template>
    <section id="dive">
        <v-container class="my-5">
            <v-row
                class="mb-6"
                no-gutters
                align="center"
                justify="center"
            >
            
                    <v-card
                    class="ma-8 pa-4"
                    width="500"
                    >

                    <v-card-title class="jsutify-center">Register</v-card-title>
                    <v-form
                        ref="form"
                        v-model="valid"
                        lazy-validation
                    >
                        <v-text-field
                            label="ID number"
                            outlined
                            v-model="payload.student_id"
                            :rules="idRules"
                        ></v-text-field>
                        <v-text-field
                            label="First Name"
                            outlined
                            v-model="payload.first_name"
                            :rules="nameRules"
                        ></v-text-field>
                        <v-text-field
                            label="Last Name"
                            outlined
                            v-model="payload.last_name"
                            :rules="nameRules"
                        ></v-text-field>
                        <v-text-field
                            label="Contact"
                            outlined
                            v-model="payload.contact"
                            :rules="contactRules"
                        ></v-text-field>
                        <v-text-field
                            label="Age"
                            outlined
                            v-model="payload.age"
                            :rules="ageRules"
                        ></v-text-field>
                        <v-text-field
                            label="Course"
                            outlined
                            v-model="payload.address"
                            :rules="addressRules"
                        ></v-text-field>
                            <v-spacer></v-spacer>
                            <div class="text-center">
                                <v-btn
                                :disabled="!valid"
                                rounded
                                color="primary"
                                dark
                                @click="validate"
                                >
                                Generate QR code
                                </v-btn>
                            </div>
                            <v-spacer></v-spacer>
                    </v-form>
                    </v-card>
                    <v-dialog
                    v-model="dialog"
                    max-width="500"
                    >
                    <v-card
                    class="pa-3"
                    >
                    <div ref="elementToSave" class="element-to-save"  style="background-color: 'white'; padding: 20px;" >
                        <div
                        class="justify-center margin"
                        align="center"
                       
                        >
                                <qr-code :text="payload.student_id" error-level="H">
                                </qr-code>
                                <img :src="logo" class="qrcode__image" contain max-width="50px"  max-height="50px" />

                               
                                <span class="text-style">{{ payload.first_name }}</span>
                                <span class="text-style">{{ payload.last_name }}</span><br/>
                                <span class="text-style">{{ payload.address }}</span><br/>
                                <span class="text-style">{{ payload.contact }}</span>
                        </div>
                        </div>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                                <v-btn 
                                rounded
                                color="primary"
                                dark
                                @click="saveAsImage()"
                                >
                                    Save QR code
                                </v-btn>
                            <v-spacer></v-spacer>
                        </v-card-actions>
                    </v-card>
                    
                    </v-dialog>
            </v-row>
        </v-container>
          
    </section>
</template>
<script>
import html2canvas from 'html2canvas';
import logo from '../../assets/logg.png'
import { SaveStudent } from "../../repositories/student.api"
export default {
    data() {
        return {
            valid : true,
            logo,
            model : null,
            message : '',
            dialog: false,
            payload : {
                student_id : '',
                first_name : '',
                last_name : '',
                age : '',
                address : '',
                contact: ''
            },
            nameRules: [
                v => !!v || 'Name is required',
                v => (v && v.length <= 10) || 'Name must be less than 10 characters',
            ],
            contactRules: [
                v => !!v || 'Contact is required',
            ],
            ageRules: [
                v => !!v || 'Age is required',
            ],
            addressRules: [
                v => !!v || 'Address is required',
            ],
            idRules: [
                v => !!v || 'id is required',
            ],
              
        }
        
    },
    methods : {
        
        async saveAsImage() {
            // Get the element that you want to save as an image
            const elementToSave = this.$refs.elementToSave;

            // Convert the element to a canvas element
            const canvas = await html2canvas(elementToSave, { backgroundColor: 'white'});

            // Get the data URL representing the image on the canvas
            const dataURL = canvas.toDataURL();

            // Create an a element
            const a = document.createElement('a');

            // Set the download attribute of the a element to the file name that you want to use
            a.download = 'image.png';

            // Set the href attribute of the a element to the data URL
            a.href = dataURL;

            // Trigger a click on the a element to start the download
            a.click();
        },
        async validate () {
                const isValid = await this.$refs.form.validate();
                if (isValid) {

                    SaveStudent(this.payload).then(({data})=> {
                        console.log(data.data)
                    })
                    this.dialog = true;

                }
        },
     }
    
}
</script>
<style scoped>
 .flex-padding {
    padding: 20px;
    background: white;
}
.text-style {
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    font-size: larger;
    font-weight: bold;
}
.qrcode__image {
  border: 0.25rem transparent;
  border-radius: 0.25rem;
  height: 15%;
  left: 50%;
  overflow: hidden;
  position: absolute;
  top: 47%;
  transform: translate(-50%, -50%);
  width: 15%;
}
.margin {
    margin-top: 50px;
}
</style>