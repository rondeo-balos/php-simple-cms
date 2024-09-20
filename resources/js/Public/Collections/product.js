export default {
    columns: [ 'product', 'image', 'description', 'price', 'sale_price', 'status' ],
    meta: {
        product: {
            control: 'text'
        },
        group: {
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
        techical: {
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