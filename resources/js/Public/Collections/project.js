export default {
    meta: {
        project: {
            control: 'text',
            default: 'Awesome Project'
        },
        image: {
            control: 'image'
        },
        description: {
            control: 'textarea',
        },
        link: {
            control: 'text',
        },
        framework: {
            control: 'text',
        },
        status: {
            control: 'select',
            default: 'On-going',
            values: {
                'On-going': 'On-going',
                'Done': 'Done'
            }
        }
    }
};