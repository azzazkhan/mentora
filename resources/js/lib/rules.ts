export const datetimeFormats = [
    /^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/, // Laravel/MySQL format
    /^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(\.\d+)?Z?$/, // ISO 8601
    /^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}(\.\d+)?$/ // Slightly modified ISO
]
