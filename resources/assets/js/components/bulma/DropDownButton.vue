<template>
    <div class="dropdown" :class="[{'is-active' : isActive}, direction]" v-on-clickaway="hideDropdown">
        <div class="dropdown-trigger" @click.prevent="isActive = !isActive">
            <button class="button" aria-haspopup="true" aria-controls="dropdown-menu"
                    :class="[{'has-no-boarder' : !boarder }, {'is-transparent' : transparent}]">
                <span>
                    <slot></slot>
                </span>
                <span class="icon is-small">
                     <i class="fa" :class="icon" aria-hidden="true"></i>
                </span>
            </button>
        </div>
        <div class="dropdown-menu" id="dropdown-menu" role="menu" ref="dropdown"
             @click.prevent="isActive = false">
            <div class="dropdown-content">
                <slot name="dropdown-items"></slot>
            </div>
        </div>

    </div>
</template>

<script>
    import {mixin as clickaway} from 'vue-clickaway';

    export default {
        mixins: [clickaway],
        data() {
            return {
                isActive: false
            }
        },
        props: {
            boarder: {
                type: Boolean,
                default: true
            },
            text: {
                type: String,
                required: false,
                default: null
            },
            icon: {
                type: String,
                default: 'fa-caret-down'
            },
            direction: {
                type: String,
                default: ''
            },
            transparent: {
                type: Boolean,
                default: true
            }
        },
        methods: {
            hideDropdown() {
                this.isActive = false;
            }
        }
    }
</script>
