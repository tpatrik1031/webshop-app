import { ref, onMounted, watch } from 'vue';
import axios from 'axios';

const cart = ref([]);

export function useCart(user) {
    const loadCart = async () => {
        try {
            const response = await axios.get('/cart');
            cart.value = response.data;
        } catch (error) {
            console.error('Failed to load cart:', error);
        }
    };

    const addToCart = async (product, quantity = 1) => {
        try {
            await axios.post('/cart/add', {
                product_id: product.id,
                quantity
            });
            await loadCart();
        } catch (error) {
            console.error('Failed to add to cart:', error);
        }
    };

    const removeFromCart = async (productId) => {
        try {
            await axios.post('/cart/remove', { product_id: productId });
            await loadCart();
        } catch (error) {
            console.error('Failed to remove from cart:', error);
        }
    };

    const updateQuantity = async (productId, quantity) => {
        try {
            await axios.post('/cart/update-quantity', {
                product_id: productId,
                quantity
            });
            await loadCart();
        } catch (error) {
            console.error('Failed to update quantity:', error);
        }
    };

    onMounted(() => {
        loadCart();
    });
    
    if (user) {
        watch(() => user.value, (newUser) => {
            if (newUser) {
                loadCart();
            }
        });
    }

    return { cart, loadCart, addToCart, removeFromCart, updateQuantity };
}
