<template>
  <ais-instant-search :search-client="searchClient" index-name="threads" query="title">
    <div class="flex justify-center px-6 my-12">
      <div class="w-full md:w-9/12 bg-white p-5 rounded-lg lg:rounded-l-none">
        <ais-search-box :show-loading-indicator="boolean" />
        <ais-hits>
          <div slot="item" slot-scope="{ item }">
            <a :href="item.path">
              <ais-highlight
                attribute="item.title"
                :class-names="{
                    'ais-Highlight-highlighted': 'font-semibold',
                }"
              />
              {{ item.title }}
            </a>
          </div>
        </ais-hits>
      </div>
      <div class="w-full md:w-3/12 bg-white p-2 rounded-lg lg:rounded-l-none ml-2">
        <h3 class="p-4 text-2xl text-center">Channels!</h3>
        <ais-refinement-list attribute="channel.name" />
      </div>
    </div>
  </ais-instant-search>
</template>

<script>
import algoliasearch from "algoliasearch/lite";
import "instantsearch.css/themes/algolia-min.css";

export default {
  data() {
    return {
      searchClient: algoliasearch(
        "SGXE06V2GE",
        "73a8654574e3b93efdc6228f5fc9274b"
      )
    };
  }
};
</script>
