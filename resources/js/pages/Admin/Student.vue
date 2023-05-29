 <template>
 <div>
    <div v-if="this.$is_admin()">
        <v-card
        >
        
            <v-data-table
                :headers="headers"
                :items="attendance"
                class="elevation-1"
                hide-default-footer
                :search="search"
                ref="table"
            >

                <template v-slot:item.action="{ item }">
                <v-switch v-model="item.is_exist" @click="active(item)"></v-switch>
                </template>
                <template v-slot:top>
                <v-toolbar
                    flat
                >
                    <v-toolbar-title>Student List</v-toolbar-title>
                    <v-divider
                    class="mx-4"
                    inset
                    vertical
                    ></v-divider>
                    <v-spacer></v-spacer>
                    <v-text-field
                        label="Search"
                        filled
                        rounded
                        dense
                        class="pt-8"
                        append-icon="mdi-magnify"
                          v-model="search"
                    ></v-text-field>
                   
                </v-toolbar>
                </template>
                
            </v-data-table>
           <!-- <v-btn @click="printToExcel"> Click</v-btn> -->

        </v-card>
        <v-spacer></v-spacer>
           <v-btn color="primary" @click="exportPDF"> Export To PDF</v-btn>

    </div>
    <div v-else>
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
                    </div>
         
        </v-sheet>
    </div>
    </div>
    </div>
 </template>
 <script>
 import Axios from '../../plugins/axios';
 import { ParticipantPagination } from '../../repositories/participant.api';
 import * as XLSX from 'xlsx';
 import * as FileSaver from 'file-saver'
 import html2pdf from 'html2pdf.js';
  import jsPDF from 'jspdf';
   import logo from '../../assets/logg.png'
    import logocard from '../../assets/logg.png'
 export default {
   data: () => ({
     dialog: false,
     dialogDelete: false,
     attendance: [],
     headers: [

       { text: 'Student ID', align: 'start', sortable: false, value: 'student_id',},
       { text: 'First Name', align: 'start', sortable: false, value: 'first_name',},
       { text: 'Last Name', align: 'start', sortable: false, value: 'last_name',},
       { text: 'Contact', align: 'start', sortable: false, value: 'contact'},
       { text: 'Age', align: 'start', sortable: false, value: 'age'},
       { text: 'Address', align: 'start', sortable: false, value: 'address'},
       { text: 'Actions', align: 'start', sortable: false, value: 'action'},
    
     ],
     loading: false,
     
      search : '',
      pageCount: 0,
      itemsPerPage:null,
      total_participants:0,
      page:1,
      current_page:0,
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
   }),
  
   watch: {
    

   },
   mounted(){
    this.initialize()
   
   }, 
 

   methods: {
    initialize(){
       Axios.get('get_student').then((response) => {
         console.log(response.data)
         this.attendance = response.data
       })

    },
    add(){
      this.$router.push('/attendee/add')
    },
    active(item){
        Axios.put('update_status/' + item.id).then(res => {
            console.log(res)
            this.initialize()
        })
      },
printToExcel() {
  const itemsWithRelatedData = this.attendance.map(item => {
    const newItem = { ...item };
    newItem.fullname = item.student.fullname; // add student letter to item object
    return newItem;
  });
  
  const worksheet = XLSX.utils.json_to_sheet(itemsWithRelatedData);
  const fullnameColumn = worksheet['E']; // get letter column
  delete worksheet['E']; // delete the original column E
  worksheet['E'] = fullnameColumn; // move letter column to column E
  delete worksheet['A']; // delete the original fullname column

  
  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, 'Sheet1');
  const excelBuffer = XLSX.write(workbook, { bookType: 'xlsx', type: 'array' });
  const blob = new Blob([excelBuffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8' });
  FileSaver.saveAs(blob, 'data.xlsx');
},

exportPDF() {
    const table = this.$refs.table.$el;
    const pdfStyles = document.createElement('link');
    pdfStyles.setAttribute('rel', 'stylesheet');
    pdfStyles.setAttribute('type', 'text/css');
    pdfStyles.setAttribute('href', '/pdf-styles.css');
    document.head.appendChild(pdfStyles); // add the PDF styles to the document head
    html2pdf().set({
      margin: 1,
      filename: 'table.pdf',
      image: { type: 'jpeg', quality: 0.98 },
      html2canvas: { dpi: 192, letterRendering: true },
      jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' },
      pagebreak: { mode: ['avoid-all', 'css'] },
    }).from(table).save();
  },

   goToAttendance() {
      this.$router.push('/attendance')
    },

  saveScan(){
      this.loadding = true
      if (this.timer) {
        clearTimeout(this.timer);
        this.timer = null
      }
      this.timer = setTimeout(() => {
        Axios.post('record', this.payload).then((response) => {
          this.payload.code = ""
          this.loading = false
          this.snackbar = true
        }).catch((errors) => {
          console.log(errors)
        });
      }, 800)
      
  },
   formatTime(dateTimeStr) {
       if (!dateTimeStr) {
        return '';
      }
      
      const dateTime = new Date(dateTimeStr);
      if (isNaN(dateTime.getTime())) {
        return dateTimeStr;
      }
      
      const hours = dateTime.getHours().toString().padStart(2, '0');
      const minutes = dateTime.getMinutes().toString().padStart(2, '0');
      const seconds = dateTime.getSeconds().toString().padStart(2, '0');
      return `${hours}:${minutes}:${seconds}`;
    },
    formatDate(dateTimeStr) {
      if (!dateTimeStr) {
        return '';
      }
      
      const dateTime = new Date(dateTimeStr);
      if (isNaN(dateTime.getTime())) {
        return dateTimeStr;
      }
      
      const year = dateTime.getFullYear().toString();
      const month = (dateTime.getMonth() + 1).toString().padStart(2, '0');
      const date = dateTime.getDate().toString().padStart(2, '0');
      return `${year}-${month}-${date}`;
    },

    
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

<style scoped>
body {
  font-family: Arial, sans-serif;
  font-size: 12px;
}

/* Add a border to the table cells */
table td, table th {
  border: 1px solid black;
}

/* Set the background color for the table headers */
table th {
  background-color: lightgray;
}
</style>
