<template>
    <div class="row">
        <div class="col-8">
            <div class="card card-default">
                <div class="card-header">Messages {{numberOfUsers}}</div>
                <div class="card-body p-0">
                    <ul class="list-unstyled" v-chat-scroll style="height: 300px; overflow-y:scroll">
                        <li class="p-2" v-for="(message, index) in messages" :key="index">
                            <strong>{{messages[index].user.name}}</strong>
                            {{message.message}}
                        </li>
                    </ul>
                </div>

                <input
                    @keydown="sendTypingEvent"
                    @keyup.enter="sendMessage"
                    v-model="newMessage"
                    type="text"
                    name="message"
                    placeholder="Enter your message..."
                    class="form-control">

            </div>

            <span class="text-muted" v-if="activeUser">{{activeUser.name}} is typing...</span>

        </div>

        <div class="col-4">
            <div class="card card-default">
                <div class="card header">Active Users</div>
                <div class="card-body">
                    <ul>

                        <li class="py-2" v-for="(user, index) in users" :key="index">
                           <span v-if="authUser === users[index].user.name">You</span>
                           <span v-else>{{users[index].user.name}}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        props: ['user'],

        data () {
            return {
                messages: [],
                newMessage: '',
                users: [],
                activeUser: false,
                typingTimer: false,
                numberOfUsers: 0,
                authUser: this.user.name,
                roomUrl:  window.location.href.substring(window.location.href.lastIndexOf('/') + 1)
            }
        },

        created() {
            this.fetchMessages();

            Echo.join('chat')
                .here(user => {
                    this.numberOfUsers = user.length;
                    this.users = user;
                })
                .joining(user => {
                    this.numberOfUsers++;
                    this.users.push(user);
                    this.$toaster.success(user.user.name + ' is joined the chat room');
                })
                .leaving(user => {
                    this.numberOfUsers--;
                    this.users = this.users.filter(u => u.user.id != user.user.id);
                    this.$toaster.warning(user.user.name + ' is leaved the chat room');
                })
                .listen('MessageSent', (event) => {
                    this.messages.push(event.message);
                })
                .listenForWhisper('typing', user => {
                    this.activeUser = user;

                    if (this.typingTimer) {
                        clearTimeout(this.typingTimer);
                    }

                    this.typingTimer = setTimeout(() => {
                        this.activeUser = false;
                    }, 3000);

                })
        },

        methods: {

            fetchMessages() {
                axios.get('../messages').then(response => {
                    this.messages = response.data;
                })
            },

            sendMessage () {

                this.messages.push({
                    user: this.user,
                    message: this.newMessage,
                });

                axios.post('../messages', {message: this.newMessage}).then(res => {
                    console.log(res);
                })
                this.newMessage = '';
            },

            sendTypingEvent() {
                Echo.join('chat')
                    .whisper('typing', this.user);
            }
        }

    }
</script>
