<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
  DialogDescription,
  DialogFooter,
} from '@/Components/ui/dialog';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Textarea } from '@/Components/ui/textarea';
import { Check, X } from 'lucide-vue-next';

const props = defineProps({
  show: Boolean,
  deposit: Object,
  type: {
    type: String,
    validator: (value) => ['approve', 'reject'].includes(value),
    default: 'approve'
  },
  onClose: Function
});

const emit = defineEmits(['close']);

const form = useForm({
  received_amount: props.deposit?.total_amount || 0,
  remaining_amount: 0,
  description: ''
});

// Computed properties for dialog content
const dialogTitle = computed(() => props.type === 'approve' ? 'Approve Deposit' : 'Reject Deposit');
const dialogDescription = computed(() => {
  return props.type === 'approve'
    ? 'Confirm the received amount and provide any notes about this deposit.'
    : 'Please provide a reason for rejecting this cash deposit.';
});

const buttonClass = computed(() => {
  return props.type === 'approve' ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700';
});

const buttonText = computed(() => props.type === 'approve' ? 'Approve' : 'Reject');
const buttonIcon = computed(() => props.type === 'approve' ? Check : X);

// Update remaining amount when received amount changes
const updateRemainingAmount = () => {
  const total = parseInt(props.deposit?.total_amount || 0);
  const received = parseInt(form.received_amount);
  form.remaining_amount = Math.max(0, total - received);
};

// Handle submit
const handleSubmit = () => {
  const routeUrl = props.type === 'approve'
    ? route('cash-deposits.approve', props.deposit.id)
    : route('cash-deposits.reject', props.deposit.id);

  form.put(routeUrl, {
    onSuccess: () => {
      emit('close');
      form.reset();
    }
  });
};

// Watch for dialog open to reset form
const onDialogOpen = () => {
  form.received_amount = props.deposit?.total_amount || 0;
  form.remaining_amount = 0;
  form.description = '';
};

const closeDialog = () => {
  emit('close');
};
</script>

<template>
  <Dialog :open="show" @update:open="closeDialog">
    <DialogContent class="sm:max-w-md">
      <DialogHeader>
        <DialogTitle>{{ dialogTitle }}</DialogTitle>
        <DialogDescription>{{ dialogDescription }}</DialogDescription>
      </DialogHeader>

      <form @submit.prevent="handleSubmit" class="space-y-4 py-4">
        <div v-if="type === 'approve'" class="space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <Label for="received_amount">Received Amount</Label>
              <Input
                id="received_amount"
                v-model="form.received_amount"
                type="number"
                step="1"
                min="0"
                :max="deposit?.total_amount"
                @input="updateRemainingAmount"
                required
              />
              <p v-if="form.errors.received_amount" class="text-red-500 text-xs mt-1">
                {{ form.errors.received_amount }}
              </p>
            </div>
            <div>
              <Label for="remaining_amount">Remaining Amount</Label>
              <Input
                id="remaining_amount"
                v-model="form.remaining_amount"
                type="number"
                step="1"
                min="0"
                disabled
              />
            </div>
          </div>
        </div>

        <div>
          <Label for="description">{{ type === 'approve' ? 'Notes' : 'Reason for Rejection' }}</Label>
          <Textarea
            id="description"
            v-model="form.description"
            :placeholder="type === 'approve' ? 'Any notes about this deposit...' : 'Reason for rejection...'"
            class="mt-1"
            rows="5"
            :required="type === 'reject'"
          />
          <p v-if="form.errors.description" class="text-red-500 text-xs mt-1">
            {{ form.errors.description }}
          </p>
        </div>

        <DialogFooter>
          <Button type="button" variant="outline" @click="closeDialog" :disabled="form.processing">
            Cancel
          </Button>
          <Button type="submit" :class="buttonClass" :disabled="form.processing">
            <component :is="buttonIcon" class="h-4 w-4" />
            {{ buttonText }}
          </Button>
        </DialogFooter>
      </form>
    </DialogContent>
  </Dialog>
</template>
