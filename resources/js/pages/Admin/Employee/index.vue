 <template>
    <div>
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
                <template v-slot:top>
                <v-toolbar
                    flat
                >
                    <v-toolbar-title>Attendee</v-toolbar-title>
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
 </template>
 <script>
 import Axios from '../../../plugins/axios';
 import { ParticipantPagination } from '../../../repositories/participant.api';
 import * as XLSX from 'xlsx';
 import * as FileSaver from 'file-saver'
 import html2pdf from 'html2pdf.js';
  import jsPDF from 'jspdf';
 export default {
   data: () => ({
     dialog: false,
     dialogDelete: false,
     headers: [

       { text: 'Student ID', align: 'start', sortable: false, value: 'student_record_id',},
       { text: 'Student Name', align: 'start', sortable: false, value: 'student.fullname',},
       { text: 'Event Name', align: 'start', sortable: false, value: 'event_name'},
       { text: 'Date', align: 'start', sortable: false, value: 'created_at'},
    
     ],
     loading: false,
     attendance: [],
      search : '',
      pageCount: 0,
      itemsPerPage:null,
      total_participants:0,
      page:1,
      current_page:0,
   }),
  
   watch: {
    

   },
   mounted(){
    this.initialize()
   }, 
 

   methods: {
    initialize(){
       Axios.get('get').then((response) => {
         console.log(response.data)
         this.attendance = response.data
       })

    },
    add(){
      this.$router.push('/attendee/add')
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
  }
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
