<template>
    <div class="dropdown" :class="[{'is-active' : isActive}, direction]" v-on-clickaway="hideDropdown">
        <div class="dropdown-trigger" @click.prevent="isActive = !isActive">
            <button class="button is-transparent" aria-haspopup="true" aria-controls="dropdown-menu" :class="!boarder ? 'has-no-boarder' : ''" >
                <span v-text="text" v-if="text"></span>
                <span class="icon is-small">
                     <i class="fa" :class="icon" aria-hidden="true"></i>
                </span>
            </button>
        </div>
        <div class="dropdown-menu" id="dropdown-menu" role="menu" ref="dropdown" >
            <div class="dropdown-content" >
                    <a class="dropdown-item" v-for="dropdown in dropdowns" @click="triggerEvent(dropdown)">
                       {{dropdown.text}}
                    </a>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    import { mixin as clickaway } from 'vue-clickaway';
    export default {
        mixins: [ clickaway ],
        data() {
            return{
                isActive: false
            }
        },
        props: {
            boarder:{
                type: Boolean,
                default: true
            },
            dropdowns:{
                type: Array,
                required: true
            },
            text:{
                type: String,
                required: false,
                default:null
            },
            icon:{
                type: String,
                default:'fa-caret-down'
            },
            direction:{
                type:String,
                default:''
            }
        },
        methods: {
            /** trigger event */
            triggerEvent(object){
                if(object.areYouSure){
                    Event.$emit('showAreYouSure', object.action, object.event.name, object.event.payload);
                    this.hideDropdown()
                    return true
                }
                Event.$emit(object.event.name, object.event.payload);
                return this.hideDropdown()
            },
            hideDropdown(){
                this.isActive = false;
            }
        }
    }
</script>
