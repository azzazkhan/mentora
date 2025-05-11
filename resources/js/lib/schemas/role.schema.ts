import { z } from 'zod'

export const RoleSchema = z.object({
    name: z.string(),
    label: z.string()
})

export type Role = z.infer<typeof RoleSchema>
