<template>
   <v-navigation-drawer
   app
   v-model = "mini"
   persistent
   :value="drawer"
    :mini-variant.sync="drawer"
   >
   
    <v-list-item class="px-2 pt-2">
        <v-img
        color="primary"
        size="40"
        :src="logocard"
        >
        </v-img>
    </v-list-item>
   
    <v-list
    dense
    padding="20px"
    >
    <template v-for="item in items">
        <v-list-item
        v-if="itemChecker(item.title)"
        :key="item.title"
        :to="item.route"
        class="text-decoration-none spacing hover"
        >
        <v-icon
        medium
        color="darken-2"
        class="pr-10"
        >
        {{ item.icon }}
        </v-icon>
        <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
        </v-list-item-content>
        </v-list-item>
    </template>

    </v-list>

   </v-navigation-drawer>
</template>
<script>
import logocard from '../../assets/logg.png'
export default {
    data : () => ({
        logocard,
        items : [
            {title : 'Attendance', icon: 'mdi mdi-account-group', route: '/attendance'},
            {title : 'Staff', icon: 'mdi mdi-account-group', route: '/staff'},
            {title : 'Students', icon: 'mdi mdi-account-group', route: '/students'},
            // {title : 'Attendance', icon: 'mdi mdi-account-group', route: '/attendance'},
         
        ]
    }),

    props : {
        mini : {
            require: true,
            type: Boolean
        }
    },
    computed : {
        activeRoute () {
            return this.$route
        },
        mini_status: { 
            get : function () {
                return this.mini
            },
            set: function (value) {
                console.log(value, "status")
                this.$emit('changeStatusDrawer')
            }
        },
        drawer: {
            get() {
            return this.$store.state.sidebar;
            },
            set(value) {
            this.$store.state.sidebar = value;
            }
        }
        
        
    },
    methods : {
        checkIfActive(route){
            let route_text = route.split("/")
            return route_text[1].includes(this.activeRoute.name)
        },

        itemChecker(item){
            let user_accepts = ['Attendance']
            let other_accepts = ['Events', "Settings"]

            if(this.$is_admin()){
                return true
            }
            else if(this.$is_user()){
                return user_accepts.includes(item)
            }
            else {
                return false
            }
        }
    }
}
</script>
<style scoped>
@keyframes bounce {
	0%, 100%, 20%, 50%, 80% {
		-webkit-transform: translateY(0);
		-ms-transform:     translateY(0);
		transform:         translateY(0)
	}
	40% {
		-webkit-transform: translateY(-30px);
		-ms-transform:     translateY(-30px);
		transform:         translateY(-30px)
	}
	60% {
		-webkit-transform: translateY(-15px);
		-ms-transform:     translateY(-15px);
		transform:         translateY(-15px)
	}
}
.spacing {
    padding-top: 0.5em;
}
.v-list-item {
    transition: transform .2s;
}

.v-list-item--active {
    background-color: #4caf50;
    color: #f4f4f4 !important;
    border-top-left-radius: 10% 50%;
    border-bottom-left-radius: 10% 50%;
    border-top-right-radius: 10% 50%;
    border-bottom-right-radius: 10% 50%;
    margin: 4%;
    padding-bottom: 2%;
    
}


.hover:hover {
    background-color: #4caf50!important;
    color: #040404 !important;
    border-top-left-radius: 10% 50%;
    border-bottom-left-radius: 10% 50%;
    border-top-right-radius: 10% 50%;
    border-bottom-right-radius: 10% 50%;
    margin: 4%;
    padding-bottom: 2%;
    cursor: pointer;
    -ms-transform: scale(1.5); /* IE 9 */
    -webkit-transform: scale(1.5); /* Safari 3-8 */
    transform: scale(1.05); 
}
.content {
    padding-left: 2em;
  }
  .left {
    padding-left: 0.3em;
  }

.v-list-group.tile > div:first-child:hover {
  background:#EF7922 !important;
}

</style>