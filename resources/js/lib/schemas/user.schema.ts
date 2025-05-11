import { z } from 'zod'
import { ModelSchema, UuidSchema } from './model.schema'

export const UserSchema = z.object({
    name: z.string(),
    avatar: z.string().nullable()
})

export const ProtectedUserSchema = UserSchema.extend({
    email: z.string()
})

export const UserModelSchema = UserSchema.merge(ModelSchema).merge(UuidSchema)
export const ProtectedUserModelSchema = UserModelSchema.merge(ProtectedUserSchema).extend({
    verified: z.string().datetime().nullable()
})

export type User = z.infer<typeof UserSchema>
export type UserModel = z.infer<typeof UserModelSchema>
export type ProtectedUser = z.infer<typeof ProtectedUserSchema>
export type ProtectedUserModel = z.infer<typeof ProtectedUserModelSchema>
