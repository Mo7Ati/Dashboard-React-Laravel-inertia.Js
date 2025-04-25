export enum EStatus {
    ACTIVE = 'active',
    ARCHIVED = 'archived',
}

export type CategoryType = {
    id: number;
    name: string;
    description: string;
    image: any;
    image_url: any;
    status: EStatus;
    parent: CategoryType;
    parent_id?: number | string;
    removeImage: boolean;
    _method: 'PUT' | 'POST';
}

export type ProductType = {
    id: number;
    name: string;
    category_id: number;
    category: CategoryType;
    store_id: number;
    store: any; //edit later
    price: number;
    compare_price: number,
    quantity: number;
    tags: string[];
    description: string;
    image: any;
    image_url: any;
    status: EStatus;
    removeImage: boolean;
    _method: 'PUT' | 'POST';
}

export type StoreType = {
    id: number;
    name: string;
    logo_image: any;
    logo_url: string;
    description: string;
    status: EStatus;
    _method: 'PUT' | 'POST';
    removeImage: boolean;
}

export type TagType = {
    id: number,
    name: string,
}

export type RoleType = {
    id: number;
    name: string;
    abilities: AbilityType[];
    _method: 'PUT' | 'POST';

}
export type AbilityType = {
    ability: string;
    value: any;
}


