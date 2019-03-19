
# coding: utf-8

# In[34]:

from random import randint


# In[35]:

# 创建随机数组进行排序
def create_array(size=10, max=50):
    return [randint(0,max) for _ in range(size)]

random_array=create_array()
random_array


# > <font color=red size=3>以下代码实现快速排序 quicksort()</font>

# In[36]:

def quicksort(a):
    if len(a)<=1: return a
    smaller,equal,larger=[],[],[]
    pivot=a[randint(0,len(a)-1)] #从数组中随机选择一个元素作为pivot，避免worst case
    
    for x in a:
        if x<pivot:    smaller.append(x)
        elif x==pivot: equal.append(x)
        else:          larger.append(x)
    
    return quicksort(smaller)+equal+quicksort(larger)

sorted_array= quicksort(random_array)
print(random_array)
print(sorted_array)


# In[ ]:



