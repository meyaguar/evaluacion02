export interface NavigationItem {
  id: string;
  title: string;
  type: 'item' | 'collapse' | 'group';
  translate?: string;
  icon?: string;
  hidden?: boolean;
  url?: string;
  classes?: string;
  groupClasses?: string;
  exactMatch?: boolean;
  external?: boolean;
  target?: boolean;
  breadcrumbs?: boolean;
  children?: NavigationItem[];
  link?: string;
  description?: string;
  path?: string;
}

export const NavigationItems: NavigationItem[] = [
  {
    id: 'maestros',
    title: 'Datos Maestros',
    type: 'group',
    icon: 'icon-master',
    children: [
      {
        id: 'productos',
        title: 'Productos',
        type: 'item',
        classes: 'nav-item',
        url: '/clientes',
        icon: 'product'
      },
      {
        id: 'proveedores',
        title: 'Proveedores',
        type: 'item',
        classes: 'nav-item',
        url: '/proveedores',
        icon: 'provider'
      }
    ]
  },
  {
    id: 'compras',
    title: 'Compras',
    type: 'group',
    icon: 'icon-shopping',
    children: [
      {
        id: 'orden-de-compra',
        title: 'Orden de Compra',
        type: 'item',
        classes: 'nav-item',
        url: '/orden-de-compra',
        icon: 'order'
      },
      {
        id: 'factura-de-compra',
        title: 'Factura de Compra',
        type: 'item',
        classes: 'nav-item',
        url: '/factura-de-compra',
        icon: 'invoice'
      }
    ]
  },
  {
    id: 'ventas',
    title: 'Ventas',
    type: 'group',
    icon: 'icon-sales',
    children: [
      {
        id: 'pedido-de-cliente',
        title: 'Pedido de Cliente',
        type: 'item',
        classes: 'nav-item',
        url: '/pedido-de-cliente',
        icon: 'customer'
      },
      {
        id: 'factura-de-venta',
        title: 'Factura de Venta',
        type: 'item',
        classes: 'nav-item',
        url: '/factura-de-venta',
        icon: 'sale'
      }
    ]
  }
];