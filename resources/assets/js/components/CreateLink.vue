<template>
    <div class="panel panel-default">
        <div class="panel-heading">Create a link</div>
        <div class="panel-body">
            <form v-on:submit.prevent="submit()">
                <div class="form-group" v-bind:class="{'has-error': errors.url, 'has-feedback': errors.url}">
                    <input type="text" v-model="url" class="form-control" placeholder="URL">
                    <span class="glyphicon glyphicon-remove form-control-feedback" v-bind:class="{'hidden': ! errors.url}"></span>
                    <span class="text-danger" v-for="error in errors.url">{{ error }}</span>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" v-model="protected">
                        Protect
                    </label>
                </div>
                <div class="form-group" v-if="protected == true" v-bind:class="{'has-error': errors.password, 'has-feedback': errors.password}">
                    <input type="password" v-model="password" class="form-control" placeholder="Password">
                    <span class="glyphicon glyphicon-remove form-control-feedback" v-bind:class="{'hidden': ! errors.password}"></span>
                    <span class="text-danger" v-for="error in errors.password">{{ error }}</span>
                </div>
                <button class="btn btn-primary">Cut</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                url: '',
                password: undefined,
                protected: false,
                errors: {}
            }
        },
        methods: {
            submit() {
                let self = this;
                self.errors = {}

                axios.post('/api/links', {
                    url: this.url,
                    password: this.password
                })
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    if (error.response.status == 422) {
                        self.errors = error.response.data
                    } else {
                        alert('Server error.');
                    }
                })
            }
        },
        watch: {
            protected: function (value) {
                if (value == false) {
                    this.password = undefined
                }
            }
        }
    }
</script>
