import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

export default function imagePath(path) {
    return `${path}`; // Assuming asset_url is a string
}
// export default function imagePath(path) {
//     const page = usePage();
//     const asset_url = computed(() => page.props.asset_url);
//     return `${asset_url.value}${path}`; // Assuming asset_url is a string
// }

