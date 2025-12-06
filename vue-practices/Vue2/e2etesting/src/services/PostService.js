import { ref } from "vue";

class PostService {
  post;
  posts;

  constructor() {
    this.post = ref({});
    this.posts = ref([]);
  }

  getPost() {
    return this.post;
  }

  getPosts() {
    return this.posts;
  }

  async fetchAll() {
    try {
      const url = "https://jsonplaceholder.typicode.com/posts";
      const response = await fetch(url);
      const json = await response.json();
      this.posts.value = await json;
    } catch (error) {
      console.log(error);
    }
  }

  async fetchById(id) {
    try {
      const url = `https://jsonplaceholder.typicode.com/posts/${id}`;
      const response = await fetch(url);
      const json = await response.json();
      this.post.value = await json;
    } catch (error) {
      console.log(error);
    }
  }
}

export default PostService;
