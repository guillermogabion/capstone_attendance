<template>
    <section id="home">
        
        <v-parallax
            height="700"
            :src="home"
            class="bottom-spacing"
        >
            <v-row
            class="padding-top"
            >
                <v-col>
                    <v-col>
                        <div>
                            <span class="wpr top"><span class="big-title">San Isidro National HighSchool</span></span>
                            <span class="wpr"><span class="small-title">Event Attendance Management System</span></span>
                            <!-- <v-btn
                                rounded
                                outlined
                                large
                                @click="$vuetify.goTo('#dive')"
                                class="mt-5 wpr buttoned from-left"
                            >
                                Explore Now
                                <v-icon class="ml-2">mdi-arrow-down</v-icon>
                            </v-btn> -->
                        </div>
                        
                        
                    </v-col>
                </v-col>
                <v-col>
          
                </v-col>
            </v-row>
        </v-parallax>
       
        <!-- <v-parallax
            height="800"
            :src="hero"
            jumbotron
            fade-img-on-scroll
        >
    dawdaw
    </v-parallax> -->
    </section>
</template>
<script>
import home from '../../assets/student.jpg'
import logo from '../../assets/logonew.png'
export default {
    data() {
        return {
            home,
            logo
        }
    },
}
</script>
<style>
    .bg-image {
    /* The image used */

        /* Add the blur effect */
        filter: blur(5px);
        -webkit-filter: blur(3px);

        /* Full height */
        height: 100%;

        /* Center and scale the image nicely */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .big-title {
        font-size: 80px;
        font-weight: bold;
        background: -webkit-linear-gradient(#af9006 ,  #474848);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        filter: drop-shadow(2px 2px #333);
    }
    .small-title {
        font-size: 30px;
        font-weight: bold;
        background: -webkit-linear-gradient(#011a28 ,  #474848);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        filter: drop-shadow(2px 2px #333);
    }
    .wpr
    {
        float:right;
        clear:both;
    }
    .wpc
    {
        float:center;
        padding-top: 3em;
        clear:both;
    }
    .top {
        padding-top: 15em;
    }
    .buttoned {
        position: relative;	
        padding: 1.4rem 4.2rem;
        padding-right: 3.1rem;
        font-size: 1.4rem;
        color: var(--inv);
        text-transform: uppercase;
        transition: all 500ms cubic-bezier(0.77, 0, 0.175, 1);	
        cursor: pointer;
        user-select: none;
    }
    .buttoned:before, .buttoned:after {
	content: '';
	position: absolute;	
	transition: inherit;
	z-index: -1;
    }

    .buttoned:hover {
        color: var(--def);
        transition-delay: .5s;
    }

    .buttoned:hover:before {
        transition-delay: 0s;
    }

    .buttoned:hover:after {
        background: var(--inv);
        transition-delay: .35s;
    }
    .from-left:before, 
    .from-left:after {
        top: 0;
        width: 0;
        height: 100%;
    }

    .from-left:before {
        right: 0;
        border: 1px solid var(--inv);
        border-left: 0;
        border-right: 0;	
    }

    .from-left:after {
        left: 0;
    }

    .from-left:hover:before,
    .from-left:hover:after {
        width: 100%;
    }
    .bottom-spacing {
    }
    .padding-top {
        padding-top: -70px;
    }
    .center {
    margin: auto;
    width: 100%;
    padding-top: 100%;
    }

    
</style>
