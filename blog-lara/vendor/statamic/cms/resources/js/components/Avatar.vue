<template>

    <div class="rounded-full overflow-hidden" v-tooltip="user.name">
        <img v-if="useAvatar" :src="avatarSrc" class="block" @error="hasAvatarError = true" />
        <div v-if="useInitials" class="text-center flex items-center justify-center h-full w-full bg-pink text-white"><span>{{ initials }}</span></div>
    </div>

</template>

<script>
export default {

    props: {
        user: Object
    },

    data() {
        return {
            hasAvatarError: false,
        }
    },

    computed: {

        initials() {
            return this.user.initials || '?';
        },

        useAvatar() {
            return this.hasAvatar && !this.hasAvatarError;
        },

        hasAvatar() {
            return !! this.user.avatar;
        },

        avatarSrc() {
            if (! this.hasAvatar) return null;

            return this.user.avatar.permalink || this.user.avatar;
        },

        useInitials() {
            return ! this.hasAvatar || this.hasAvatarError;
        }

    }

}
</script>
