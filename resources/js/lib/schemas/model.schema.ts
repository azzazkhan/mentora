import { z } from 'zod'
import { datetimeFormats } from '../rules'

export const UidSchema = z.object({
    uid: z.string()
})

export const UuidSchema = z.object({
    uuid: z.string().uuid()
})

export const TimestampSchema = z.object({
    created_at: z.string().refine((val) => datetimeFormats.some((r) => r.test(val))),
    updated_at: z.string().refine((val) => datetimeFormats.some((r) => r.test(val)))
})

export const ModelSchema = TimestampSchema.extend({
    id: z.coerce.number().positive()
})

export const DeletableModelSchema = ModelSchema.extend({
    deleted_at: z
        .string()
        .refine((val) => datetimeFormats.some((r) => r.test(val)))
        .nullable()
})
