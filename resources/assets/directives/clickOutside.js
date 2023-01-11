export default {
    bind: function (el, binding, vNode) {
        el.__vueClickOutside__ = event => {
            if (!el.contains(event.target)) {
                // call method provided in v-click-outside value
                vNode.context[binding.expression](event)
                event.stopPropagation()
            }
        }
        document.body.addEventListener('click', el.__vueClickOutside__)
    },
    unbind: function (el, binding, vNode) {
        // Remove Event Listeners
        document.removeEventListener('click', el.__vueClickOutside__)
        el.__vueClickOutside__ = null
    }
}
