<template>
	<div>
	<nav class="panel column is-offset-2 is-8">
		<p class="panel-heading">
			Vuejs Phonebook
			<button class="button is-primary is-outlined" @click="openAdd">
				Add New
			</button>
			<span class="is-pulled-right" v-if="loading">
				<i class="fa fa-refresh fa-spin fa-2x fa-fw"></i>
			</span>
		</p>
		<div class="panel-block">
			<p class="control has-icons-left">
				<input class="input is-small" type="text" placeholder="search" v-model="searchQuery">
				<span class="icon is-small is-left">
					<i class="fa fa-search has-text-link" aria-hidden="true" ></i>
				</span>
			</p>
		</div>

		<div class="panel-block" v-for="item,key in tempList">
			<span class="column is-9 is-capitalized">
				{{ item.name }}
			</span>
			<span class="panel-icon column is-1">
				<i class="has-text-danger fa fa-trash" style="cursor:pointer" @click="deleteItem(key,item.id)" aria-hidden="true"></i>
			</span>
			<span class="panel-icon column is-1">
				<i class="has-text-info fa fa-edit" style="cursor:pointer" @click="openUpdate(key)" aria-hidden="true"></i>
			</span>
			<span class="panel-icon column is-1">
				<i class="has-text-primary fa fa-eye has-icon" style="cursor:pointer" aria-hidden="true" @click="openShow(key)"></i>
			</span>
		</div>		
	</nav>
	<Add :openmodal="addActive" @closeRequest="close"></Add>
	<Show :openmodal="showActive" @closeRequest="close"></Show>
	<Update :openmodal="updateActive" @closeRequest="close"></Update>
	</div>	
</template>

<script>
	const Add = require('./Add.vue');
	const Show = require('./Show.vue');
	const Update = require('./Update.vue');	
	export default{

		components:{Add,Show,Update},
		data(){
			return{
				addActive : '',
				showActive : '',
				updateActive:'',
				lists:{},
				tempList:{},
				searchQuery:'',
				loading:false,
				errors:'',
			}			
		},
		created(){
			axios.post('/getData')
					 .then(res => this.tempList = this.lists = res.data)
					 .catch(err => this.errors = err.response.data.errors);
		},
		watch:{
			searchQuery(){				
				if (this.searchQuery.length > 0) {					
					this.tempList = this.lists.filter(item => item.name.toLowerCase().indexOf(this.searchQuery.toLowerCase()) > -1)
				}else{
					this.tempList=this.lists;
				}				
			}
		},
		// updated(){
		// 	axios.post('/getData')
		// 			 .then(res => this.lists = res.data)
		// 			 .catch(err => this.errors = err.response.data.errors);	
		// },
		methods:{
			openAdd(){
				this.addActive = 'is-active';
			},
			openShow(key){
				this.$children[1].list = this.lists[key];
				this.showActive = 'is-active';
			},
			openUpdate(key){
				this.$children[2].list = this.lists[key];
				this.updateActive = 'is-active';
			},
			deleteItem(key,id){				
				if(confirm('Are You Sure?')){
					this.loading = !this.loading;
					axios.delete(`/phonebook/${id}`)
					 .then(res => {
					 	this.lists.splice(key,1);
					 	this.loading = !this.loading;})
					 .catch(err => this.errors = err.response.data.errors);	
				}			
			},
			close(){
				this.addActive = this.showActive = this.updateActive = '';
			}
		}
	}
</script>