<template>

<div id="current-projects">

<h2>Open Projects</h2>

<div v-for="project in projects" class="card">
    <h4>{{project.title}}</h4>
    <h5>{{project.totalNewPropsals}} New propsals</h5>
    <h5>{{project.totalPropsals}} Total propsals</h5>
</div>

</div>

<div id="messages">
    <h1>Recent Messages</h1>
    <ul>
       <li @click="openMessage(message.id)" class="flex" :class="message.read ? 'unread' : ''" v-for="message in latestMessages">
            <h6>{{message.author}}</h6>
            <p>{{message.snippet}}</p>
       </li>
       </ul>
</div>

</template>

<script setup>

const projects = ref([]);
const latestMessages = ref([]);

const getProjects = async () => {

    const data = new FormData();

    data.append('user_id' , User.id);
    
    data.append('session_id' , User.sessionId);

    data.append('action' , 'get_projects');

    const request = await fetch('/wp-admin/admin-ajax.php', {
        method : "POST",
        body : data
    });

    const response = await request.json();

    projects = response;

}

const getRecentMessages = async () => {

    const data = new FormData();

    data.append('user_id' , User.id);
    
    data.append('session_id' , User.sessionId);

    data.append('action' , 'get_latest_messages');

    const request = await fetch('/wp-admin/admin-ajax.php', {
        method : "POST",
        body : data
    });

    const response = await request.json();

    latestMessages = response;

}

 get_projects();

</script>