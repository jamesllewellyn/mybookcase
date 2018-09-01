<template>
    <div class="column is-half">
        <div class="card book-shelf">
            <div class="card-content">
                <div class="columns is-mobile">
                    <div class="column is-one-third is-paddingless icon-container">
                        <span class="icon is-large">
                            <i class="fas fa-3x fa-info-circle is-centered"></i>
                        </span>
                    </div>
                    <div class="column is-two-thirds message-container">
                        <p class="message-text book-title has-text-weight-bold">
                            <slot ></slot>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<style lang="scss" scoped>
    .icon-container, .message-container{
        display: flex;
        justify-content: center;
        min-height:135px;
    }
    .icon{
        /*margin-top:25%;*/
        color: #dbdbdb !important;
        vertical-align: middle;
        height:100%;
    }
    .message-text{
        display: inline-flex;
        height:100%;
        align-items: center;
        vertical-align: middle;
    }
    /*.is-vertical-center {*/
        /*display: flex;*/
        /*align-items: center;*/
    /*}*/
</style>
