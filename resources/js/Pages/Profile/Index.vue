<script setup>
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Button } from '@/Components/ui/button'
import { Input } from '@/Components/ui/input'
import { Label } from '@/Components/ui/label'
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/Components/ui/card'
import { Avatar, AvatarImage, AvatarFallback } from '@/Components/ui/avatar'
import { Badge } from '@/Components/ui/badge'
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/Components/ui/tabs'

// Dummy user data
const user = ref({
  id: 1,
  name: 'John Doe',
  email: 'john.doe@transportco.com',
  role: 'Branch Manager',
  branch: 'Central Station',
  contactNumber: '+254 712 345 678',
  joinDate: '2023-05-15',
  profileImage: null,
  recentActivity: [
    { type: 'trip_assigned', message: 'Assigned Trip #45678 to Driver Thomas', date: '2025-03-14' },
    { type: 'maintenance', message: 'Approved maintenance request for vehicle KBZ-432X', date: '2025-03-12' },
    { type: 'complaint', message: 'Resolved customer complaint #2234', date: '2025-03-10' },
    { type: 'fuel', message: 'Approved fuel request for 3 vehicles', date: '2025-03-08' },
  ],
  stats: {
    tripsManaged: 145,
    vehiclesSupervised: 12,
    complaintsResolved: 24,
    maintenanceApproved: 18
  },
  permissions: ['manage_vehicles', 'approve_maintenance', 'assign_drivers', 'view_reports', 'manage_trips']
})

// Form handling
const personalInfo = ref({
  name: user.value.name,
  email: user.value.email,
  contactNumber: user.value.contactNumber
})

const saving = ref(false)

const savePersonalInfo = () => {
  saving.value = true
  // Simulate API call
  setTimeout(() => {
    user.value.name = personalInfo.value.name
    user.value.email = personalInfo.value.email
    user.value.contactNumber = personalInfo.value.contactNumber
    saving.value = false
  }, 1000)
}

// Activity type badges
const activityColor = (type) => {
  switch(type) {
    case 'trip_assigned': return 'bg-blue-100 text-blue-800'
    case 'maintenance': return 'bg-amber-100 text-amber-800'
    case 'complaint': return 'bg-purple-100 text-purple-800'
    case 'fuel': return 'bg-green-100 text-green-800'
    default: return 'bg-gray-100 text-gray-800'
  }
}
</script>

<template>
  <Head title="Profile" />

  <AuthenticatedLayout>
    <div class="container mx-auto p-6">
      <div class="flex flex-col gap-6">
        <!-- Profile Header -->
        <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
          <Avatar class="w-24 h-24">
            <AvatarImage v-if="user.profileImage" :src="user.profileImage" />
            <AvatarFallback class="text-2xl">{{ user.name.charAt(0) }}</AvatarFallback>
          </Avatar>

          <div class="flex-1">
            <h1 class="text-3xl font-bold">{{ user.name }}</h1>
            <div class="flex flex-wrap gap-2 mt-2">
              <Badge variant="secondary">{{ user.role }}</Badge>
              <Badge variant="outline">{{ user.branch }}</Badge>
            </div>
            <p class="text-sm text-gray-500 mt-2">Member since {{ new Date(user.joinDate).toLocaleDateString() }}</p>
          </div>

          <Button>Edit Profile Photo</Button>
        </div>

        <!-- Tabs Section -->
        <Tabs default-value="overview" class="w-full">
          <TabsList class="grid grid-cols-3 w-full md:w-1/2">
            <TabsTrigger value="overview">Overview</TabsTrigger>
            <TabsTrigger value="personal">Personal Info</TabsTrigger>
            <TabsTrigger value="activity">Activity</TabsTrigger>
          </TabsList>

          <!-- Overview Tab -->
          <TabsContent value="overview">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Stats Card -->
              <Card>
                <CardHeader>
                  <CardTitle>Performance Stats</CardTitle>
                  <CardDescription>Your management statistics</CardDescription>
                </CardHeader>
                <CardContent>
                  <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col">
                      <span class="text-sm text-gray-500">Trips Managed</span>
                      <span class="text-2xl font-bold">{{ user.stats.tripsManaged }}</span>
                    </div>
                    <div class="flex flex-col">
                      <span class="text-sm text-gray-500">Vehicles Supervised</span>
                      <span class="text-2xl font-bold">{{ user.stats.vehiclesSupervised }}</span>
                    </div>
                    <div class="flex flex-col">
                      <span class="text-sm text-gray-500">Complaints Resolved</span>
                      <span class="text-2xl font-bold">{{ user.stats.complaintsResolved }}</span>
                    </div>
                    <div class="flex flex-col">
                      <span class="text-sm text-gray-500">Maintenance Approved</span>
                      <span class="text-2xl font-bold">{{ user.stats.maintenanceApproved }}</span>
                    </div>
                  </div>
                </CardContent>
              </Card>

              <!-- Permissions Card -->
              <Card>
                <CardHeader>
                  <CardTitle>System Permissions</CardTitle>
                  <CardDescription>Your assigned access roles</CardDescription>
                </CardHeader>
                <CardContent>
                  <div class="flex flex-wrap gap-2">
                    <Badge v-for="permission in user.permissions" :key="permission" variant="outline" class="capitalize">
                      {{ permission.replace('_', ' ') }}
                    </Badge>
                  </div>
                </CardContent>
              </Card>
            </div>
          </TabsContent>

          <!-- Personal Info Tab -->
          <TabsContent value="personal">
            <Card>
              <CardHeader>
                <CardTitle>Personal Information</CardTitle>
                <CardDescription>Update your personal details</CardDescription>
              </CardHeader>
              <CardContent>
                <form class="grid gap-4">
                  <div class="grid w-full gap-2">
                    <Label for="name">Full Name</Label>
                    <Input id="name" v-model="personalInfo.name" />
                  </div>
                  <div class="grid w-full gap-2">
                    <Label for="email">Email</Label>
                    <Input id="email" type="email" v-model="personalInfo.email" />
                  </div>
                  <div class="grid w-full gap-2">
                    <Label for="contact">Contact Number</Label>
                    <Input id="contact" v-model="personalInfo.contactNumber" />
                  </div>
                  <div class="grid w-full gap-2">
                    <Label for="branch">Branch</Label>
                    <Input id="branch" :value="user.branch" disabled />
                  </div>
                  <div class="grid w-full gap-2">
                    <Label for="role">Role</Label>
                    <Input id="role" :value="user.role" disabled />
                  </div>
                </form>
              </CardContent>
              <CardFooter class="flex justify-end">
                <Button @click="savePersonalInfo" :disabled="saving">
                  {{ saving ? 'Saving...' : 'Save Changes' }}
                </Button>
              </CardFooter>
            </Card>
          </TabsContent>

          <!-- Activity Tab -->
          <TabsContent value="activity">
            <Card>
              <CardHeader>
                <CardTitle>Recent Activity</CardTitle>
                <CardDescription>Your latest system interactions</CardDescription>
              </CardHeader>
              <CardContent>
                <div class="space-y-4">
                  <div v-for="(activity, index) in user.recentActivity" :key="index" class="flex items-start gap-3 pb-3 border-b border-gray-100">
                    <div :class="['w-2 h-2 mt-2 rounded-full', activityColor(activity.type)]"></div>
                    <div class="flex-1">
                      <p>{{ activity.message }}</p>
                      <p class="text-sm text-gray-500">{{ new Date(activity.date).toLocaleDateString() }}</p>
                    </div>
                  </div>
                </div>
              </CardContent>
              <CardFooter>
                <Button variant="outline" class="w-full">View All Activity</Button>
              </CardFooter>
            </Card>
          </TabsContent>
        </Tabs>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
