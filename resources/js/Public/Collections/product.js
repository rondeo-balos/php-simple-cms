export default {
    columns: [ 'product', 'image', 'description', 'price', 'sale_price', 'status' ],
    icon: 'http://127.0.0.1:8000/storage/media/6iUG5XeP2tk1keCYunOzUfpdxxFNXripdqY9IrOd.svg',
    meta: {
        product: {
            control: 'text'
        },
        group_1: {
            fields: {
                image: {
                    control: 'image'
                },
                description: {
                    control: 'textarea'
                }
            }
        },
        long_description: {
            control: 'richtext'
        },
        group_2: {
            fields: {
                price: {
                    control: 'number',
                    default: 1
                },
                sale_price: {
                    control: 'number',
                    default: 0.5
                },
                status: {
                    control: 'select',
                    default: 'Draft',
                    values: {
                        'Draft': 'Draft',
                        'Published': 'Published'
                    }
                }
            }
        }
    }
};