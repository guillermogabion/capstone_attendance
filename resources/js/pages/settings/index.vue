<template>
    <div
    class="flex flex-row gap-2 bg-transparent"
    style="height: 90vh; max-height: 90vh;"
    >
        <v-row
        no-gutters
        >
            <v-col
           cols="2"
            >
                <v-navigation-drawer permanent>
                    <v-list nav>
                        <v-list-item
                        v-for="item in menus"
                        :key="item.title"
                        :to="item.route"
                        class="text-decoration-none hover"
                        >
                            <v-list-item-icon>
                                <v-icon>{{ item.icon }}</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>
                                    {{item.title}}
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-navigation-drawer>
            </v-col>
            <v-col
        
            >
                <div class="bg-white overflow-auto">
                    <transition name="fade" mode="in-out">
                        <router-view />
                    </transition>
                </div>
            </v-col>
        </v-row>
    </div>
</template>
<script>
export default {
    data() {
        return {
            menus : [
                {title : 'Manage Events', icon: "mdi-bullseye-arrow", route: '/setting/item'  },
                // {title : 'Delivery',  icon: "mdi-bullseye-arrow", route: '/setting/delivery' },
                // {title : 'Category',  icon: "mdi-bullseye-arrow", route: '/setting/category' },
             
            ]
        }
    },
}
</script>

<style scoped>
.v-list-item--active {
    background-color: #4caf50;
    color: #f4f4f4 !important;
    margin: 4%;
    padding-bottom: 2%;
    
}
.hover:hover {
    background-color: #4caf50!important;
    color: #040404 !important;
    margin: 4%;
    padding-bottom: 2%;
    cursor: pointer;
    -ms-transform: scale(1.5); /* IE 9 */
    -webkit-transform: scale(1.5); /* Safari 3-8 */
    transform: scale(1.05); 
}
</style>