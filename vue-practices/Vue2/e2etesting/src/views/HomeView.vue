<template>
    <section class="home">
        <header class="header">
            <h1>Post list</h1>
            <div class="controls">
                <input
                    v-model="search"
                    type="search"
                    class="search"
                    placeholder="Search by id, title or body..."
                    aria-label="Search posts"
                />
            </div>
        </header>

        <div class="table-wrap">
            <table class="posts-table">
                <thead>
                    <tr>
                        <th @click="toggleSort('id')" class="clickable">
                            ID
                            <span class="sort">{{ sortKey === 'id' ? (sortDesc ? ' ↓' : ' ↑') : '' }}</span>
                        </th>
                        <th @click="toggleSort('title')" class="clickable"> 
                            Title
                            <span class="sort">{{ sortKey === 'title' ? (sortDesc ? ' ↓' : ' ↑') : '' }}</span>
                        </th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="post in filteredAndSorted" :key="post.id">
                        <td class="mono">{{ post.id }}</td>
                        <td>{{ post.title }}</td>

                        <td>
                            <RouterLink :to="{ name: 'detail', params: { id: post.id } }" class="btn">View</RouterLink>
                        </td>
                    </tr>
                    <tr v-if="filteredAndSorted.length === 0">
                        <td colspan="4" class="empty">No posts found.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>

<script setup>
import PostService from '@/services/PostService';
import { onMounted, ref, computed } from 'vue';

const postService = new PostService();
const posts = postService.getPosts();

const search = ref('');
const sortKey = ref('id');
const sortDesc = ref(false);

const filteredAndSorted = computed(() => {
    const q = search.value.trim().toLowerCase();
    let list = Array.isArray(posts.value) ? posts.value.slice() : [];

    if (q) {
        list = list.filter((p) => {
            return (
                String(p.id).includes(q) ||
                (p.title && p.title.toLowerCase().includes(q)) ||
                (p.body && p.body.toLowerCase().includes(q))
            );
        });
    }

    list.sort((a, b) => {
        const aKey = a[sortKey.value];
        const bKey = b[sortKey.value];
        if (aKey == null && bKey == null) return 0;
        if (aKey == null) return sortDesc.value ? -1 : 1;
        if (bKey == null) return sortDesc.value ? 1 : -1;

        if (typeof aKey === 'number' && typeof bKey === 'number') {
            return sortDesc.value ? bKey - aKey : aKey - bKey;
        }

        const sa = String(aKey).toLowerCase();
        const sb = String(bKey).toLowerCase();
        if (sa < sb) return sortDesc.value ? 1 : -1;
        if (sa > sb) return sortDesc.value ? -1 : 1;
        return 0;
    });

    return list;
});

function toggleSort(key) {
    if (sortKey.value === key) {
        sortDesc.value = !sortDesc.value;
    } else {
        sortKey.value = key;
        sortDesc.value = false;
    }
}

onMounted(async () => {
    await postService.fetchAll();
});
</script>

<style scoped>
.home {
    padding: 1rem;
    max-width: 1000px;
    margin: 0 auto;
}
.header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1rem;
}
.controls {
    display: flex;
    align-items: center;
}
.search {
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    border: 1px solid #ddd;
    min-width: 220px;
}
.table-wrap {
    overflow: auto;
    background: white;
    border-radius: 10px;
    box-shadow: 0 6px 18px rgba(20,20,40,0.06);
}
.posts-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 680px;
}
.posts-table thead th {
    text-align: left;
    padding: 12px 16px;
    border-bottom: 1px solid #eef2f5;
    background: linear-gradient(180deg, #fafafa, #fff);
    font-weight: 600;
    font-size: 0.95rem;
}
.posts-table tbody td {
    padding: 12px 16px;
    border-bottom: 1px solid #f4f6f8;
    vertical-align: middle;
}
.posts-table tbody tr:hover td {
    background: linear-gradient(90deg, rgba(250,250,255,1), rgba(244,248,252,1));
}
.btn {
    display: inline-block;
    padding: 6px 10px;
    background: #2b6cb0;
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.9rem;
}
.mono { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, 'Roboto Mono', monospace; }
.excerpt { color: #556; font-size: 0.95rem; }
.clickable { cursor: pointer; user-select: none; }
.sort { color: #9aa; margin-left: 6px; font-weight: 600; }
.empty { text-align: center; padding: 24px; color: #667; }

@media (max-width: 720px) {
    .posts-table { min-width: 0; }
    .excerpt { display: none; }
}
</style>