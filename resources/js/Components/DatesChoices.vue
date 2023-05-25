<template>
    <div>
        <button class="button flex gap-5 items-center" :class="isFocus ? 'focus' : ''" type="button" @click="toggleModal()">
            <font-awesome-icon class="text-xl" icon="fa-regular fa-calendar" />
            <span class="font-bold text-lg">Choisissez vos dates</span>
            <font-awesome-icon icon="fa-solid fa-chevron-down" />
        </button>

        <transition name="fade">
            <div class="modal" v-show="isModalOpen" @click.self="toggleModal()">
                <div class="body-modal">
                    <font-awesome-icon @click="toggleModal()" class="text-2xl close cursor-pointer" icon="fa-solid fa-xmark" />

                    <h3 class="text-center text-xl font-bold text-gray-700">Sélectionnez vos dates</h3>
                    <p class="text-center md:w-3/4 xl:w-1/2 mx-auto mt-3">
                        Nous vous recommandons une date de livraison 2 à 3 jours avant l'évènement (évitez les dimanches et jours fériés)
                    </p>


                    <div class="flex gap-6 mt-4">
                        <div class="flex flex-col flex-1">
                            <span>Du: </span>
                            <input class="w-full" type="date" v-model="startDate" :min="min" @change="endDate = null"/>
                        </div>

                        <div class="flex flex-col flex-1">
                            <span>Au: </span>
                            <input class="w-full" type="date" v-model="endDate" :min="startDatePlusTwo" :max="startDatePlusTwenty" :disabled="! startDate"/>
                        </div>
                    </div>

                    <p class="text-red-700" v-if="dateErrors">{{ dateErrors }}</p>

                    <div class="flex flex-col lg:flex-row gap-5 mt-6">
                        <span class="flex-1 flex flex-col items-center justify-center text-center bg-gray-200 py-3 px-2 rounded-3xl">
                            Livraison le
                            <span class="block font-bold">
                                {{ formatDate(startDate) }}
                            </span>
                        </span>

                        <span class="flex-1 flex flex-col items-center justify-center text-center bg-gray-200 py-3 px-2 rounded-3xl">
                            À retourner avant le
                            <span class="block font-bold">
                                {{ formatDate(endDatePlusOne) }}
                            </span>
                        </span>

                        <button class="flex-1 flex flex-col items-center justify-center text-white text-center bg-black py-3 px-2 rounded-3xl" type="button" @click="valider()" :disabled="!startDate || !endDate">Valider</button>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import moment from 'moment';

export default {
    data() {
        return {
            isModalOpen: false,
            startDate: null,
            endDate: null,
            isFocus: false
        }
    },

    props: ["dateErrors"],

    methods: {
        toggleModal() {
            this.isModalOpen = ! this.isModalOpen;
        },

        valider() {
            this.$emit('startDate', this.startDate);
            this.$emit('endDate', this.endDate);
            this.isModalOpen = false;
        },

        focus() {
            this.isFocus = true;
            setTimeout(() => {
                this.isFocus = false;
            }, 1000);
        },

        formatDate(date) {
            if (!date) return;

            date = moment(date);

            return date.format('DD/MM/YYYY');
        }
    },

    computed: {
        min() {
            const date = moment();

            return date.add('5', 'days').format('YYYY-MM-DD');
        },

        startDatePlusTwo() {
            if (!this.startDate) return;

            const date = moment(this.startDate);

            return date.add('2', 'days').format('YYYY-MM-DD');
        },

        startDatePlusTwenty() {
            if (!this.startDate) return;

            const date = moment(this.startDate);

            return date.add('20', 'days').format('YYYY-MM-DD');
        },
        
        endDatePlusOne() {
            if (!this.endDate) return;

            const date = moment(this.endDate);

            return date.add('1', 'days').format('YYYY-MM-DD');
        }
    }
}
</script>

<style scoped>
.button {
    box-shadow: 0px 0px 30px #00000017;
    background: #FFFFFF 0% 0% no-repeat padding-box;
    color: black;
    padding: 17px 28px;
    transition: 200ms ease;
}

.focus {
    border: 1px solid red;
    transform: scale(1.05);
}

.modal {
    position: fixed;
    height: 100vh;
    width: 100%;
    background: rgba(0, 0, 0, 0.3);
    top: 0;
    left: 0;
    z-index: 10000000;
    display: flex;
    justify-content: center;
    align-items: center;
}

.body-modal {
    width: 600px;
    max-width: 100%;
    padding: 30px 40px;
    border-radius: 30px;
    background: white;
    position: relative;
}

.close {
    position: absolute;
    top: 25px;
    right: 25px;
}

.datepicker {
  position: relative;
}

.datepicker-container {
  position: absolute;
  top: 100%;
  left: 0;
  z-index: 999;
  background-color: white;
  border: 1px solid #ccc;
  padding: 10px;
}

.datepicker-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}

.datepicker-body {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 5px;
}

.datepicker-day {
  text-align: center;
  cursor: pointer;
}
</style>