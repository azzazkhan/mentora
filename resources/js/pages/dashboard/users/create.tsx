import { DashboardLayout, Page } from '@/components/layout/dashboard'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Form, FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form'
import { Input } from '@/components/ui/input'
import { MultiSelect } from '@/components/ui/multi-select'
import { ProtectedUserSchema, RoleSchema } from '@/lib/schemas'
import { Option } from '@/lib/utils'
import { Breadcrumb } from '@/types/components'
import { zodResolver } from '@hookform/resolvers/zod'
import { useForm } from 'react-hook-form'
import { z } from 'zod'

export const CreateUserFormSchema = ProtectedUserSchema.extend({
    roles: z.array(RoleSchema.shape.name),
    password: z.string().min(8).max(30)
})

export type CreateUserForm = z.infer<typeof CreateUserFormSchema>

interface Props {
    roles: Option[]
}

export default function CreateUser({ roles }: Props) {
    const breadcrumbs: Breadcrumb[] = [
        { label: 'Dashboard', link: route('dashboard') },
        { label: 'Users', link: route('dashboard.users.index') },
        { label: 'Create' }
    ]

    const form = useForm<CreateUserForm>({
        resolver: zodResolver(CreateUserFormSchema),
        defaultValues: {
            name: '',
            email: '',
            password: '',
            avatar: '',
            roles: []
        }
    })

    const onSubmit = (data: CreateUserForm) => {
        console.log({ data })
    }

    console.log(roles)

    return (
        <DashboardLayout>
            <Page title="Create User" breadcrumbs={breadcrumbs}>
                <Form {...form}>
                    <form onSubmit={form.handleSubmit(onSubmit)}>
                        <div className="grid gap-6 @xl/page:grid-cols-3">
                            <div className="@xl/page:order-2 @xl/page:col-span-1"></div>

                            <Card className="@xl/page:order-1 @xl/page:col-span-2">
                                <CardHeader>
                                    <CardTitle>Basic Details</CardTitle>
                                </CardHeader>
                                <CardContent className="grid gap-6 @xl/page:grid-cols-6">
                                    <FormField
                                        control={form.control}
                                        name="name"
                                        render={({ field: { value, ...field } }) => (
                                            <FormItem className="@xl/page:col-span-3">
                                                <FormLabel>Name</FormLabel>
                                                <FormControl>
                                                    <Input placeholder="John Doe" value={value || ''} {...field} />
                                                </FormControl>
                                                <FormMessage />
                                            </FormItem>
                                        )}
                                    />

                                    <FormField
                                        control={form.control}
                                        name="email"
                                        render={({ field: { value, ...field } }) => (
                                            <FormItem className="@xl/page:col-span-3">
                                                <FormLabel>Email</FormLabel>
                                                <FormControl>
                                                    <Input placeholder="john@doe.com" value={value || ''} {...field} />
                                                </FormControl>
                                                <FormMessage />
                                            </FormItem>
                                        )}
                                    />

                                    <FormField
                                        control={form.control}
                                        name="password"
                                        render={({ field: { value, ...field } }) => (
                                            <FormItem className="@xl/page:col-span-3">
                                                <FormLabel>Password</FormLabel>
                                                <FormControl>
                                                    <Input
                                                        placeholder="Enter a strong password"
                                                        value={value || ''}
                                                        {...field}
                                                    />
                                                </FormControl>
                                                <FormMessage />
                                            </FormItem>
                                        )}
                                    />

                                    <FormField
                                        control={form.control}
                                        name="roles"
                                        render={({ field }) => (
                                            <FormItem className="@xl/page:col-span-3">
                                                <FormLabel>Roles</FormLabel>
                                                <FormControl>
                                                    <MultiSelect
                                                        options={roles.map(({ label, value }) => ({
                                                            label,
                                                            value
                                                        }))}
                                                        onValueChange={field.onChange}
                                                        placeholder="Select roles"
                                                    />
                                                </FormControl>
                                                <FormMessage />
                                            </FormItem>
                                        )}
                                    />
                                </CardContent>
                            </Card>

                            <div className="flex items-center justify-end gap-x-2 @xl/page:order-4 @xl/page:col-span-2">
                                <Button variant="outline">Cancel</Button>
                                <Button type="submit">Create</Button>
                            </div>

                            {/* <BasicFields control={form.control} className="@xl/page:order-1 @xl/page:col-span-2" />
                            <AdditionalFields control={form.control} className="@xl/page:order-3 @xl/page:col-span-2" />
                            <div className="@xl/page:order-2">
                                <RelationalFields
                                    genres={genres}
                                    tags={tags}
                                    control={form.control}
                                    className="@xl/page:order-2"
                                />
                            </div> */}
                        </div>
                    </form>
                </Form>
            </Page>
        </DashboardLayout>
    )
}
