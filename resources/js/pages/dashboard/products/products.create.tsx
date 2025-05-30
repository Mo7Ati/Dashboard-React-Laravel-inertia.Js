import AppLayout from "@/layouts/app-layout";
import { BreadcrumbItem } from "@/types";
import { Head } from "@inertiajs/react";
import ProductForm from "./products.form";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: '/products',
    },
];


export default function CreateProduct(props: any) {

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Categories" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <ProductForm {...props} formType={'create'} />
            </div>
        </AppLayout >
    );
}
